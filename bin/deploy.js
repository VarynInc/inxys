/**
 * Deploy the local site to -d or -q
 * Verify changed files first, run deploy with `npm run deploy`
 * Run deploy with `npm run deploy` or `npm run deploy -- --no-dryrun`
 * After deploy, test on the target stage e.g. https://inxys-q.net
 * Copy emails to Enginesis: `npm run deploy-email` or `npm run deploy-email -- --no-dryrun`
 */
import Rsync from "rsync";
import chalk from "chalk";
import fs from "fs";
import path from "path";
import shell from "shelljs";
import args from "yargs";
import { hideBin } from "yargs/helpers";

const defaultConfigurationFilePath = "bin/deploy-config.json";
let rsyncFlags = "zrptcv";
let debug = false;
let configuration = {};

/**
 * Set defaults for things that we may not receive from the configuration file
 * or the command line. There are certain parameters that we cannot default and
 * must be provided.
 */
const configurationDefault = {
    site: "inxys",
    targetstage: "-q",
    isDryRun: false,
    destinationHost: "",
    destinationUser: "",
    destinationPassword: "",
    destinationPath: "/var/www/vhosts/inxys-q",
    excludeFiles: "./bin/exclude-inxys-files.txt",
    sourcePath: "./",
    email: false,
    emailSourcePath: "./sitedev/email/",
    emailDestinationPath: "../Enginesis/public/sites/",
    sshKeyFile: "",
    debug: false,
    logFile: "",
    configurationFile: defaultConfigurationFilePath
}

/**
 * Load the required configuration information from a JSON file.
 * This file contains sensitive information and must be secure
 * (don't put it in version control, and keep access rights restricted to 600.)
 * @param {string} configurationFilePath path to a configuration file.
 * @returns {object} The configuration data or an empty object if no data is available.
 */
function loadConfigurationData(configurationFilePath) {
    if (fs.existsSync(configurationFilePath)) {
        let rawData = fs.readFileSync(configurationFilePath);
        if (rawData != null) {
            return JSON.parse(rawData) || {};
        }
    }
    return {};
}

/**
 * Merge the configuration information with the default values. Anything found
 * in the loaded configuration file will override a default.
 * @param {object} configurationDefault Default configuration information.
 * @return {object} Configuration information.
 */
function mergeConfigurationData(configurationDefault) {
    const args = getArgs();
    debug = args.verbose;
    let configuration;
    let configurationFilePath = args.config || defaultConfigurationFilePath;
    if (configurationFilePath.length > 0) {
        configuration = loadConfigurationData(configurationFilePath);
        if (Object.keys(configuration).length === 0) {
            immediateLog("Configuration file " + configurationFilePath + " does not exist or is not a valid format.");
        } else {
            immediateLog("Loading configuration from " + configurationFilePath, false);
        }
    }
    for (let property in configurationDefault) {
        if (property != "configurationFile" && configurationDefault.hasOwnProperty(property) && ! configuration.hasOwnProperty(property)) {
            configuration[property] = configurationDefault[property];
        }
    }
    mergeArgs(args, configuration);
    if (configuration.hasOwnProperty("debug")) {
        debug = configuration.debug;
    }
    return configuration;
}

/**
 * Overwrite any configuration options with values provided on the command line.
 * Command line has precedence over config file.
 * @param {object} args Command line arguments.
 * @param {object} configuration Default configuration information.
 * @return {object} Configuration information.
 */
function mergeArgs(args, configuration) {
    if (args.destination) {
        configuration.destinationPath = args.destination;
    }
    if (args.site) {
        configuration.site = args.site;
    }
    if (args.host) {
        configuration.destinationHost = args.host;
    }
    if (args.key) {
        configuration.sshKeyFile = args.key;
    }
    if (args.log) {
        configuration.logFile = args.log;
    }
    if (args.source) {
        configuration.sourcePath = args.source;
    }
    if (args.targetstage) {
        configuration.targetstage = args.targetstage;
    }
    if (args.user) {
        configuration.destinationUser = args.user;
    }
    if (args.exclude) {
        configuration.excludeFiles = args.exclude;
    }
    if (args.hasOwnProperty('email') && args.email) {
        configuration.email = args.email;
    }
    if (args.hasOwnProperty('verbose') && args.verbose) {
        configuration.debug = args.verbose;
    }
    if (args.hasOwnProperty('dryrun')) {
        configuration.isDryRun = args.dryrun;
    }
    console.log(chalk.blue("isDryRun is " + (configuration.isDryRun?"true":"false")));
    return configuration;
}

/**
 * Overwrite any configuration options with values provided on the command line.
 * @return {object} Args object.
 */
function getArgs() {
    return args(process.argv)
    .options({
        "c": {
            alias: "config",
            type: "string",
            describe: "path to config file",
            demandOption: false,
            default: defaultConfigurationFilePath
        },
        "d": {
            alias: "destination",
            type: "string",
            describe: "destination root path to copy to on host",
            demandOption: false
        },
        "e": {
            alias: "site",
            type: "string",
            describe: "set which site to deploy",
            demandOption: false
        },
        "h": {
            alias: "host",
            type: "string",
            describe: "host domain to copy to",
            demandOption: false
        },
        "k": {
            alias: "key",
            type: "string",
            describe: "path to ssh key file (pem format)",
            demandOption: false
        },
        "l": {
            alias: "log",
            type: "string",
            describe: "path to log file",
            demandOption: false
        },
        "m": {
            alias: "email",
            boolean: true,
            describe: "deploy email source files to local Enginesis instance",
            demandOption: false,
            default: false
        },
        "s": {
            alias: "source",
            type: "string",
            describe: "set the source file root folder",
            demandOption: false
        },
        "t": {
            alias: "targetstage",
            type: "string",
            describe: "set the server stage to deploy to",
            demandOption: false
        },
        "u": {
            alias: "user",
            type: "string",
            describe: "user on destination to login as (using key file)",
            demandOption: false
        },
        "v": {
            alias: "verbose",
            boolean: true,
            describe: "turn on debugging",
            demandOption: false,
            default: false
        },
        "x": {
            alias: "exclude",
            type: "string",
            describe: "path to exclude file list (text file)",
            demandOption: false
        },
        "y": {
            alias: "dryrun",
            boolean: true,
            describe: "perform dry run (no actual sync)",
            demandOption: false,
            default: true
        },
    })
    .alias("?", "help")
    .help()
    .argv;
}

/**
 * Write a message to a log file.
 * @param {string} message The message to post in the log.
 */
function writeToLogFile(message) {
    if (configuration && configuration.logFile) {
        try {
            fs.appendFileSync(configuration.logFile, message + "\r\n");
        } catch (err) {
            console.log(chalk.red("Error writing to " + configuration.logFile + ": " + err));
        }
    }
}

/**
 * Show an error message in the log and on the console but only if debugging is enabled.
 * @param {string} message A message to display.
 */
function errorLog(message) {
    if (debug) {
        console.log(chalk.red(message));
        writeToLogFile(message);
    }
}

/**
 * Show an information message in the log and on the console but only if debugging is enabled.
 * @param {string} message A message to display.
 */
function debugLog(message) {
    if (debug) {
        console.log(chalk.green(message));
        writeToLogFile(message);
    }
}

/**
 * Show a message in the log and on the console immediately.
 * @param {string} message A message to display.
 */
function immediateLog(message, error = true) {
    if (error) {
        console.log(chalk.red(message));
    } else {
        console.log(chalk.blue(message));
    }
    writeToLogFile(message);
}

/**
 * Update the build info and save it in a JSON file.
 */
function updateBuildInfoFile() {
    const buildFileName = 'build-info.json';
    const buildFolder = './public';
    const buildFile = path.join(buildFolder, buildFileName);
    const buildInfo = {
        packageName: shell.env['npm_package_name'],
        version: shell.env['npm_package_version'],
        publish_date: (new Date()).toISOString(),
        user: shell.env['USER']
    };
    shell.echo(JSON.stringify(buildInfo)).to(buildFile);
}

/**
 * Deploy the site to the target environment (usually either -d or -q) by using ssh to connect
 * to the server and rsync to synchronize the file set. This will use this environment as the
 * source of truth and overwrite or delete any non-matching files on the target.
 * @param {object} configuration The configuration parameters.
 */
function deploy(configuration) {
    const site = configuration.site;
    const isDryRun = configuration.isDryRun;
    const sourcePath = configuration.sourcePath;
    const excludeFiles = configuration.excludeFiles;
    const dryRunFlag = "n";
    let sshCommand = "ssh";
    let destinationPath;
    let logMessage = "Deploying " + site + " to " + configuration.targetstage + " on " + (new Date).toISOString();

    if (configuration.destinationUser.length > 0 && configuration.destinationHost.length > 0) {
        destinationPath = configuration.destinationUser + "@" + configuration.destinationHost + ":" + configuration.destinationPath;
    } else {
        destinationPath = configuration.destinationPath;
    }
    if (configuration.logFile && fs.existsSync(configuration.logFile)) {
        fs.unlinkSync(configuration.logFile);
    }
    if (isDryRun) {
        rsyncFlags += dryRunFlag;
        logMessage += " -- This is a DRY RUN - no files will be copied."
    } else {
        updateBuildInfoFile();
    }
    if (configuration.sshKeyFile) {
        sshCommand += " -i " + configuration.sshKeyFile;
    }
    immediateLog(logMessage, false);
    immediateLog("Syncing " + site + " " + sourcePath + " with target stage " + configuration.targetstage + " " + configuration.destinationPath, false);
    debugLog("sourcePath " + sourcePath);
    debugLog("destinationPath " + destinationPath);
    debugLog("sshCommand " + sshCommand);
    debugLog("rsync flags " + rsyncFlags);
    debugLog("excludeFiles " + excludeFiles);
    debugLog("log to " + configuration.logFile);
    debugLog("debug " + configuration.debug);

    let rsync = new Rsync()
        .shell(sshCommand)
        .flags(rsyncFlags)
        .delete()
        .set("exclude-from", excludeFiles)
        .source(sourcePath)
        .destination(destinationPath);

    if (isDryRun) {
        immediateLog("Review deploy dry run " + site + " to " + destinationPath, false);
    } else {
        immediateLog("Deploy " + site + " to " + destinationPath, false);
    }

    rsync.execute(function(error, exitCode, cmd) {
        const timeNow = (new Date).toISOString();
        if (error) {
            immediateLog("Site deploy fails for " + site + " " + error.toString() + " at " + timeNow);
        } else if (isDryRun) {
            immediateLog("Site dry run for " + site + " complete at "  + timeNow);
        } else {
            immediateLog("Site deploy for " + site + " complete at "  + timeNow);
        }
    }, function (output) {
        // stdout
        debugLog(output);
    }, function (output) {
        // stderr
        errorLog(output);
    });
}

/**
 * Assuming the email files have been updated on this local environment, update the matching
 * email files on the local Enginesis environment. From there those emails should be optimized
 * and then deployed to Enginesis servers.
 * @param {object} configuration The configuration parameters.
 */
function deployEmail(configuration) {
    const site = configuration.site;
    const isDryRun = configuration.isDryRun;
    const sourcePath = configuration.emailSourcePath;
    const destinationPath = configuration.emailDestinationPath + configuration.siteId + "/email/";
    const excludeFiles = configuration.excludeFiles;
    const dryRunFlag = "n";
    let logMessage = "Deploying emails to " + destinationPath + " on " + (new Date).toISOString();

    if (configuration.logFile && fs.existsSync(configuration.logFile)) {
        fs.unlinkSync(configuration.logFile);
    }
    if (isDryRun) {
        rsyncFlags += dryRunFlag;
        logMessage += " -- This is a DRY RUN - no files will be copied."
    }
    immediateLog(logMessage, false);
    let rsync = new Rsync()
        .shell("ssh")
        .flags(rsyncFlags)
        .set("exclude-from", excludeFiles)
        .source(sourcePath)
        .destination(destinationPath);

    if (isDryRun) {
        immediateLog("Review copy dry run " + site + " emails to " + destinationPath, false);
    } else {
        immediateLog("Copy " + site + " emails to " + destinationPath, false);
    }

    rsync.execute(function(error, exitCode, cmd) {
        const timeNow = (new Date).toISOString();
        if (error) {
            immediateLog("Email deploy fails for " + site + " " + error.toString() + " at " + timeNow);
        } else if (isDryRun) {
            immediateLog("Email dry run for " + site + " complete at "  + timeNow);
        } else {
            immediateLog("Email deploy for " + site + " complete at "  + timeNow);
        }
    }, function (output) {
        // stdout
        debugLog(output);
    }, function (output) {
        // stderr
        errorLog(output);
    });
}

/**
 * Detect which platform we are running on, because some things cannot be done from
 * a Windows computer.
 */
function platformDetect() {
    if (process.platform == "win32") {
        immediateLog("Deploy task does not work on Windows systems.");
        process.exit(29);
    }
}

platformDetect();
configuration = mergeConfigurationData(configurationDefault);
if (configuration.email) {
    deployEmail(configuration);
} else {
    deploy(configuration);
}
