/**
 * Copy the common module files from their source folder to this project.
 */
import path from "path";
import chalk from "chalk";
import fsExtra from "fs-extra";

const configuration = {
    isLoggingInfo: true,
    isLoggingError: true,
    destinationPath: "./",
    librariesSourcePath: "../../libraries/",
    librariesManifest: [
        {
            source: "EnginesisSDK/enginesis-php/source/Enginesis.php",
            destination: "services/Enginesis.php"
        },
        {
            source: "EnginesisSDK/enginesis-php/source/EnginesisErrors.php",
            destination: "services/EnginesisErrors.php"
        },
        {
            source: "EnginesisSDK/enginesis-js/js/enginesis.cjs",
            destination: "public/js/enginesis.js"
        }
    ]
};

/**
 * Helper function to control logging.
 * @param {string} message
 */
function logInfo(message) {
    if (configuration.isLoggingInfo) {
        console.log(message);
    }
}
/**
 * Helper function to control logging.
 * @param {string} message
 */
function logError(message) {
    if (configuration.isLoggingError) {
        console.warn(chalk.red("ᚎ " + message));
    }
}

async function updateModuleFiles() {
    configuration.librariesManifest.forEach(async function(fileProperties) {
        const sourceFile = path.join(configuration.librariesSourcePath, fileProperties.source);
        const destinationFile = path.join(configuration.destinationPath, fileProperties.destination);
        try {
            await fsExtra.copy(sourceFile, destinationFile)
            logInfo(`Copied ${sourceFile} to ${destinationFile}`);
        } catch (copyError) {
            logError(`Error trying to copy ${sourceFile} to ${destinationFile}: ` + copyError.toString());
        }
    });
}

updateModuleFiles();
