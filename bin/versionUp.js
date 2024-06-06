/**
 Update the version of the project by selectively updating specific files.
 Files are specified in the array filesContainingVersion.
 We expect to find a semantic version string "#.#.#" in the first file.
 In each file specified, we replace the first occurrence of #.#.# with the new version number.
 **/

 const fs = require("fs");
 const path = require("path");
 const commandLineArgs = require("yargs");
 
 // The current version is based off the first file, incremented, and updated in all files:
 var filesContainingVersion = [
     "services/version.php",
     "package.json"
 ];
 var pathToRoot;
 var debug = true;
 var versionUpdateTask;
 
 function debugLog(message) {
     if (debug) {
         console.log(message);
     }
 }
 
 function setParameters() {
     const options = commandLineArgs.argv;
     if (typeof options.debug !== "undefined") {
         debug = options.debug;
     } else {
         debug = true;
     }
     if (typeof options.task !== "undefined") {
         versionUpdateTask = options.task;
     } else {
         versionUpdateTask = "build";
     }
     if (typeof options.path !== "undefined") {
         pathToRoot = options.path;
     } else {
         pathToRoot = "./";
     }
     if (typeof options.src !== "undefined") {
         filesContainingVersion = options.src;
     }
     debugLog("Options are: " + JSON.stringify({
             debug: debug,
             path: pathToRoot,
             task: versionUpdateTask,
             files: filesContainingVersion
         }));
 }
 
function versionUp(task) {
    const versionMatch = "[\"'][0-9]+\.[0-9]+\.[0-9]+[\"']";
    const nextFile = pathToRoot + filesContainingVersion[0];
    let currentVersion = "";
    fs.readFile(nextFile, "utf8", function (error, fileContents) {
        if (error != null) {
            debugLog("Error  reading " + nextFile + " " + error.toString());
        } else {
            let searchPos = fileContents.search(versionMatch);
            if (searchPos >= 0) {
                const firstChar = searchPos + 1;
                let lastChar = fileContents.substring(firstChar).search("[\"']");
                if (lastChar >= 0) {
                    lastChar += firstChar;
                    currentVersion = fileContents.substring(
                        firstChar,
                        lastChar
                    );
                }
            }
            if (currentVersion != "") {
                let nextVersion = currentVersion.split(".");
                let major = parseInt(nextVersion[0], 10);
                let minor = parseInt(nextVersion[1], 10);
                let buildNumber = parseInt(nextVersion[2], 10);
                switch (task) {
                    case "major":
                        major++;
                        minor = 0;
                        buildNumber = 0;
                        break;

                    case "minor":
                        minor++;
                        buildNumber = 0;
                        break;

                    case "build":
                        buildNumber++;
                        break;

                    default:
                        break;
                }
                nextVersion = major + "." + minor + "." + buildNumber;
                debugLog("Current version in " + nextFile + " is " + currentVersion + ". Next version will be " + nextVersion);

                filesContainingVersion.forEach(function (sourceFile) {
                    sourceFile = pathToRoot + sourceFile;
                    fs.readFile(sourceFile, { encoding: "utf8", flag: "r+" }, function (error, fileContent) {
                        if (error) {
                            debugLog("Reading file " + sourceFile + " fails with " + error.toString());
                        } else {
                            var regExp = new RegExp(versionMatch);
                            var posOfVersion = fileContent.search(regExp);
                            if (posOfVersion >= 0) {
                                fs.writeFile(
                                    sourceFile,
                                    fileContent.replace(regExp, "\"" + nextVersion + "\""),
                                    {
                                        encoding: "utf8",
                                        flag: "w+"
                                    },
                                    function (fileError) {
                                        if (fileError != null) {
                                            debugLog("Writing file " + sourceFile + " fails with " + fileError.toString());
                                        } else {
                                            debugLog("Updated file " + sourceFile + " with version " + nextVersion);
                                        }
                                    });
                            } else {
                                debugLog("Version information not found in file " + sourceFile);
                            }
                        }
                    });
                });
            } else {
                debugLog("Current version is not found in " + nextFile);
            }
        }
    });
 }
 
 setParameters();
 versionUp(versionUpdateTask);
 