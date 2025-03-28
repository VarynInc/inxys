/**
 * Build the sitemap from ./public/sitemap/sitemap.json to ./public/sitemap/index.php and ./public/sitemap.xml.
 * The concept here is an external process maintains the JSON format for the site index, such as a CMS. We can't
 * just have a process that scans the entire source of the site as there are probably folders and files we want
 * excluded from the site map and overall better control over what goes in to it (including dynamic data such as
 * conferences, users, and promos). The JSON file drives the complete construction of two files. There is the
 * sitemap.xml that is provided to search engines, and there is sitemap/index.php that is used on the site as a
 * complete site index for users.
 */
import chalk from "chalk";
import fs from "fs";
import axios from "axios";
import fetch from "node-fetch";
import * as cheerio from "cheerio";
import enginesis from "../public/js/enginesis.js";

let isLoggingInfo = true;
let isLoggingError = true;
let pathToPublicRoot = "./public";
let siteRoot = "https://inxys.net";
let devSiteRoot = "https://inxys-l.net";
let sitemapSource = "./public/sitemap/sitemap.json";
let sitemapPage = "./public/sitemap/index.php";
let sitemapPageTemplate = "./views/pageTemplate.php";
let sitemapXML = "./public/sitemap.xml";
let enginesisParameters = {
    siteId: 109,
    gameId: 0,
    gameGroupId: 0,
    serverStage: "enginesis.inxys-l.net",
    authToken: "",
    developerKey: "34A9EBE91B578504",
    languageCode: "en",
    callBackFunction: null
};

let sitemap = null;
let pendingRequests = 0;

/**
 * Replace occurrences of {token} with matching keyed values from parameters array.
 *
 * @param {string} text text containing tokens to be replaced.
 * @param {Array} parameters array/object of key/value pairs to match keys as tokens in text and replace with value.
 * @return {string} text replaced string.
 */
function tokenReplace (text, parameters) {
    for (let token in parameters) {
        if (parameters.hasOwnProperty(token)) {
            const regexMatch = new RegExp("\{" + token + "\}", "g");
            text = text.replace(regexMatch, parameters[token]);
        }
    }
    return text;
};

/**
 * Helper function to control logging informational progress messages.
 * @param {string} message
 */
function logInfo(message) {
    if (isLoggingInfo) {
        console.log(chalk.green(message));
    }
}
/**
 * Helper function to control logging errors.
 * @param {string} message
 */
function logError(message) {
    if (isLoggingError) {
        console.log(chalk.red("ᚎ " + message));
    }
}

/**
 * Determine if a proposed file path leads to a valid file. If it leads to a subfolder, determine if
 * a valid index page exists in that folder.
 * @param {string} proposedFileName A file path to check.
 * @returns {string|null} The file path, possibly changed if an index file is found. Otherwise null if not a valid path.
 */
function getTrueFileFromLoc(proposedFileName) {
    let fileOK = true;
    let filePath = pathToPublicRoot + proposedFileName;
    if (filePath[filePath.length - 1] == "/") {
        let checkFilePath = filePath + "index.php";
        if (fs.existsSync(checkFilePath)) {
            filePath = checkFilePath;
        } else {
            checkFilePath = filePath + "index.html";
            if (fs.existsSync(checkFilePath)) {
                filePath = checkFilePath;
            } else {
                filePath = null;
            }
        }
    } else if ( ! fs.existsSync(filePath)) {
        filePath = null;
    }
    return filePath;
}

/**
 * Render an HTML representation of the page by loading the web page from the development server (assumes you
 * are building a sitemap from the site that's currently in development), scraping the title and description,
 * and formatting a list item of that information.
 *
 * @param {object} section A specification of a single page in the site index. Expected format is:
 *   {
 *     "loc": "https://inxys.net/path/from/webiste/root/",
 *     "changefreq": "monthly",
 *     "priority": 0.8
 *   }
 * @returns {Promise} A Promise that resolves with the page HTML (title, description, and link) or rejects if
 *   an error is encountered trying to load the page.
 */
function renderSectionHTML(section) {
    return new Promise(function (resolve, reject) {
        let html;
        let url = section.loc;
        if (url) {
            let fullURL = devSiteRoot + url;
            let title = "";
            let description = "";
            axios({
                url: fullURL,
                method: "get"
            })
            .then(function(response) {
                if (response.status != 200) {
                    reject(new Error("Request for " + fullURL + " gives status " + response.statusCode + ": this is not supported."));
                } else {
                    const webPage = cheerio.load(response.data);
                    if (webPage) {
                        title = webPage("title").text();
                        description = webPage("meta[name=description]").attr("content");
                        html = `\n<li><a href="${url}">${title}</a> ${description}</li>\n`;
                        resolve(html);
                    } else {
                        reject(new Error("Request for " + fullURL + " did not return HTML."));
                    }
                }
            })
            .catch(function(error) {
                logError("Request for " + fullURL + " fails with " + error.toString());
                reject(error);
            });
        } else {
            reject(new Error("Could not resolve loc to a valid HTML file."));
        }
    });
}

/**
 * Render an XML element representing the section as part of a sitemap.
 * @param {object} section A specification of a single page in the site index. Expected format is:
 *   {
 *     "loc": "https://inxys.net/path/from/website/root/",
 *     "changefreq": "monthly",
 *     "priority": 0.8
 *   }
 * @returns {string|null} Returns an XML string for a single <url> element of a sitemap. Returns null if the section
 *   is invalid or leads to an invalid file reference.
 */
function renderSectionXML(section) {
    let xml;
    let url = section.loc;
    let frequency = section.changefreq || "weekly";
    let priority = section.priority || 0.5;
    if (url.indexOf("http") != 0) {
        url = siteRoot + url;
    }
    let filePath = getTrueFileFromLoc(section.loc);
    if (filePath != null) {
        // stat the file, get last modified date
        let fileStats = fs.statSync(filePath);
        let lastModified = new Date(fileStats.mtime).toISOString();
        xml = `<url>\n  <loc>${url}</loc>\n  <lastmod>${lastModified}</lastmod>\n  <changefreq>${frequency}</changefreq>\n  <priority>${priority}</priority>\n</url>\n`;
    } else {
        xml = null;
    }
    return xml;
}

/**
 * Process a site map entry from the site map data structure and convert it into the XML and HTML representations. The resulting
 * data is added to the data structure for later processing.
 *
 * @param {string} pageKey The key of the section to process.
 * @param {object} sitemapItem The data for the section.
 * @returns {Promise} Resolves when the page is processed.
 */
function processPage(pageKey, sitemapItem) {
    if (sitemapItem.loc != undefined) {
        sitemapItem.xml = null;
        sitemapItem.html = null;
        pendingRequests ++;
        console.log(chalk.yellow("Looking at item " + sitemapItem.loc + " in section " + pageKey));
        sitemapItem.xml = renderSectionXML(sitemapItem);
        renderSectionHTML(sitemapItem)
        .then(function (htmlFragment) {
            sitemapItem.html = htmlFragment;
            renderFilesIfProcessComplete();
        }, function (error) {
            console.log(chalk.red("  HTML for " + sitemapItem.loc + " failed with " + error.toString()));
            renderFilesIfProcessComplete();
        })
        .catch(function (exception) {
            console.log(chalk.red("  HTML exception on " + sitemapItem.loc + ": " + exception.toString()));
            renderFilesIfProcessComplete();
        });
    }
}

/**
 * A section of pages is to be generated by a query.
 * @param {string} key The key of the section to process.
 * @param {object} section The section data.
 * @param {object} sitemapSection The parent section data to the key/section we are processing.
 * @returns {Promise} Resolve when the pages are processed.
 */
function processPageQuery(key, section, sitemapSection) {
    console.log(chalk.green("  Processing a page query for " + key + " for " + section.plugin));
    if (section.plugin == "enginesis" && key == "Games") {
        enginesis.init(enginesisParameters);
        enginesis.setNodeRequest(fetch);
        enginesis.siteListGames(1, 100, 2, null).then(function (enginesisResponse) {
            if (enginesisResponse != null && enginesisResponse.fn != null) {
                let results = enginesisResponse.results;
                const succeeded = results.status.success == "1";
                if (succeeded && enginesisResponse.fn == "SiteListGames") {
                    results = results.result;
                    for (let i = 0; i < results.length; i += 1) {
                        let gameURL = siteRoot + "/play/";
                        let gameItem = results[i];
                        let title = gameItem.title;
                        let description = gameItem.short_desc;
                        let lastModified = new Date().toISOString();
                        let frequency = "monthly";
                        let priority = 0.9;
                        if (gameItem.game_type_id == 4) {
                            // quiz games only referenced by id
                            gameURL += gameItem.game_name + "?id=" + gameItem.game_id;
                        } else {
                            gameURL += gameItem.game_name;
                        }
                        let xml = `<url>\n  <loc>${gameURL}</loc>\n  <lastmod>${lastModified}</lastmod>\n  <changefreq>${frequency}</changefreq>\n  <priority>${priority}</priority>\n</url>\n`;
                        let html = `\n<li><a href="${gameURL}">${title}</a> ${description}</li>\n`;
                        sitemapSection[gameItem.game_name] = {
                            loc: gameURL,
                            changefreq: frequency,
                            priority: priority,
                            xml: xml,
                            html: html
                        };
                    }
                    console.log(chalk.green("  Added " + results.length + " entries to sitemap section " + key));
                } else {
                    errorMessage = results.status.message;
                    console.log(chalk.red("  Enginesis request for siteListGames fails with " + errorMessage));
                }
            } else {
                console.log(chalk.red("  Enginesis request failed with no information"));
            }
        }, function(enginesisError) {
            console.log(chalk.red("  Enginesis siteListGames error " + enginesisError.toString()));
        })
        .catch(function(enginesisError) {
            console.log(chalk.red("  Enginesis siteListGames exception " + enginesisError.toString()));
        });
    } else {
        console.log(chalk.green("  not the right section " + key + " for " + section.plugin));
    }
}

/**
 * After processing is complete build the XML and HTML files.
 */
function renderFilesIfProcessComplete() {
    pendingRequests --;
    if (pendingRequests < 1) {
        const fileEncoding = "utf8";
        const xmlHeader = `<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n`;
        const xmlFooter = `</urlset>\n`;
        const htmlHeader = `<div id="sitemap">\n<h2>inXys.net Site Map</h2>\n`;
        const htmlFooter = `</div>`;
        const pageTemplateOptions = {
            pagename: "home",
            pagetitle: "Site Map",
            pagedescription: "Site map index for inXys.net",
            pagecontent: null
        };
        let htmlSection;
        let XMLWriteStream = fs.createWriteStream(sitemapXML);
        let HTMLContent = htmlHeader;

        XMLWriteStream.write(xmlHeader, fileEncoding);
        for (let key in sitemap) {
            if (sitemap[key].loc == undefined) {
                htmlSection = `<div id="section-${key}">\n  <h3>${key}</h3>\n  <ul>`;
                HTMLContent += htmlSection;
                for (let section in sitemap[key]) {
                    if (sitemap[key][section].loc != undefined) {
                        if (sitemap[key][section].xml) {
                            XMLWriteStream.write(sitemap[key][section].xml, fileEncoding);
                        }
                        if (sitemap[key][section].html) {
                            HTMLContent += sitemap[key][section].html;
                        }
                    }
                }
                htmlSection = `  </ul>\n</div>\n`;
                HTMLContent += htmlSection;
            } else {
                if (sitemap[key].xml) {
                    XMLWriteStream.write(sitemap[key].html, fileEncoding);
                }
                if (sitemap[key].html) {
                    HTMLContent += sitemap[key].html;
                }
            }
        }
        XMLWriteStream.write(xmlFooter, fileEncoding);
        XMLWriteStream.end();
        HTMLContent += htmlFooter;

        let pageTemplate = fs.readFileSync(sitemapPageTemplate, fileEncoding);
        if (pageTemplate) {
            pageTemplateOptions.pagecontent = HTMLContent;
            fs.writeFileSync(sitemapPage, tokenReplace(pageTemplate, pageTemplateOptions), fileEncoding);
        }

        console.log(chalk.blue("Sitemap build complete"));
    }
}

/**
 * Load the sitemap JSON file and process it, determining the site sections and the content inside each section.
 */
function buildSiteMap() {
    console.log(chalk.blue("Buiding sitemap from " + sitemapSource));
    fs.readFile(sitemapSource, 'utf8', function (fileError, fileData) {
        if (fileError) {
            throw fileError;
        } else {
            sitemap = JSON.parse(fileData);
            if (sitemap != null && sitemap.sitemap != undefined) {
                sitemap = sitemap.sitemap;
                for (let key in sitemap) {
                    if (sitemap[key].loc == undefined) {
                        for (let section in sitemap[key]) {
                            if (sitemap[key][section].loc != undefined) {
                                processPage(key, sitemap[key][section]);
                            } else if (sitemap[key][section].plugin != undefined) {
                                processPageQuery(key, sitemap[key][section], sitemap[key]);
                            }
                        }
                    } else {
                        processPage(key, sitemap[key]);
                    }
                }
            } else {
                console.log(chalk.red("Sitemap build failed could not read JSON " + sitemapSource));
                throw new Error("Sitemap build failed could not read JSON " + sitemapSource);
            }
        }
    });
}

buildSiteMap();
