# The Information Exchange (inXys)

[Learn about inXys](https://inxys.net/about/).

This website is built with a combination of JavaScript and PHP. It uses Node.js for building and packaging.

 * HTML 5 and CSS 3
 * JavaScript ES5
 * [Bootstrap 5](https://getbootstrap.com/docs/5.0/getting-started/introduction/)
 * [PHP](https://php.net) 8.3
 * [node.js](https://nodejs.org) 22.13.1
 * [Enginesis](https://enginesis.com)
 * [PHPUnit](https://docs.phpunit.de/en/10.5/installation.html)

## Node tasks

- `test`: Run the unit tests.
- `lint`: Perform lint check on JavaScript source files.
- `versionup`: Increment the minor version number to update the app to the next version.
- `build`: Bundle the app for production.
- `deploy`: Copy the bundled production app to the -q server.
- `deployemail`: Copy the minified email files to the local Enginesis server.
- `updatemodules`: Copy the shared php and javascript libraries from local repos. 
- `sitemap`: Generate a new site map file rendering dynamic pages.
- `clean`: Remove all temporary files.

## Development

This is a PHP-based website. To run it locally you need to have a webserver (Apache 2.4) and PHP 8.3 installed on your local development machine. Then load `/index.php` in a web browser.

All public facing resources are found in the `public` folder, and this is the folder pointed to by the web server to serve those resources.

Website services are found in the `services` folder. This is only accessible via PHP since it is outside the public website.

## Testing

JavaScript unit tests are run with Jest. Run `npm test`.

PHP unit tests are run with PHPUnit. Run as follows:

```bash
cd sitedev/test
sh runtests.sh
```

The tests run this way generate all output in log files. Check the log files for the results. Or run each test separately, check the file header comments to see the CLI.

## Release

Procedure to release the website:

1. Make sure the `main` branch is up to date.
2. Run the tests: `npm test` and PHPUnit tests, and verify all tests pass.
3. Run the build `npm run build`.
4. Copy only the minified files from `./distrib/common` to `./public/common`. They should overwrite existing minified files.
5. Verify the site by opening a browser to https://inxys-l.net, clear the browser cache, and do a visual inspection of all the pages and verify a user login.
6. Run the deploy script `npm run deploy`, verify correct file updates, and then run `npm run deploy -- --no-dryrun`.
7. Rename `./data/deploy.log` to today's date `./data/deploy-YYYMMDD.log`.
8. Commit the update with the version tag.
