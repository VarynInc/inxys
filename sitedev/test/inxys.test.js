/**
 * inXys unit tests.
 * See Expect interface at https://jestjs.io/docs/expect
 */
import { inxys } from "../../public/js/inxys"
import fetch from "node-fetch";

/**
 * @jest-environment jsdom
 */

test('use jsdom in this test file', function() {
    const element = document.createElement('div');
    expect(element).not.toBeNull();
});

test('Expect inxys to exist and contain required functions', function() {
    expect(inxys).toBeDefined();
    expect(inxys.version).toBeDefined();
    let version = inxys.version;
    var versionCheck = version.match(/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(-(0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*)(\.(0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*))*)?(\+[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*)?$/);
    expect(versionCheck).toBeTruthy();
});
