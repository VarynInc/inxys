import enginesis from "/js/enginesis.js";

let waitingForServerReply = false;

const enginesisParameters = {
    siteId: 109,
    gameId: 0,
    gameGroupId: 0,
    serverStage: "enginesis.inxys-l.com",
    authToken: "",
    developerKey: "34A9EBE91B578504",
    languageCode: "en",
    callBackFunction: null
};
enginesis.init(enginesisParameters);

/**
 * Dynamically assign event handlers once the page loads.
 */
function setupFormChangeHandlers () {
    let targetElement = document.getElementById("login-show-password");
    if (targetElement != null) {
        targetElement.addEventListener("click", onClickLoginShowPassword);
    }
}

/**
 * Handle any updates to the password input control.
 * @param {Event} event Browser Event object.
 */
function onClickLoginShowPassword (event) {
    const passwordInput = document.getElementById("login-password");
    const icon = document.getElementById("show-password-icon");
    const text = document.getElementById("show-password-text");
    const show = icon.classList.contains("iconEyeSlash");

    if (show) {
        passwordInput.type = 'password';
        icon.className = 'iconEye';
        text.innerText = 'Show';
    } else {
        passwordInput.type = 'text';
        icon.className = 'iconEyeSlash';
        text.innerText = 'Hide';
    }
}

setupFormChangeHandlers();
