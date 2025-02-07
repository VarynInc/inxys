/**
 * Enginesis unit tests.
 * Expects the UserData module to load and operate as designed.
 * See Expect interface at https://jestjs.io/docs/expect
 */
import enginesis from "../../public/js/enginesis";
import fetch from "node-fetch";

/**
 * @jest-environment jsdom
 */

test('use jsdom in this test file', function() {
    const element = document.createElement('div');
    expect(element).not.toBeNull();
});

test('Expect enginesis to exist and contain required functions', function() {
    expect(enginesis).toBeDefined();
    expect(enginesis.init).toBeDefined();
    expect(enginesis.isUserLoggedIn).toBeDefined();
    expect(enginesis.versionGet).toBeDefined();
    expect(enginesis.conferenceTopicList).toBeDefined();
});

test('Expect enginesis version to be #.#.#', function () {
    var version = enginesis.versionGet();
    var versionCheck = version.match(/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(-(0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*)(\.(0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*))*)?(\+[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*)?$/);
    expect(versionCheck).toBeTruthy();
});
