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
 * Determine if a string looks like a valid email address.
 * @param {string} email String to expect an email address
 * @returns {boolean} true if we think it is a valid email address.
 */
function isValidEmail (email) {
    return /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()\.,;\s@\"]+\.{0,1})+([^<>()\.,;:\s@\"]{2,}|[\d\.]+))$/.test(email);
};

/**
 * Watch for changes to the user name so we can verify it.
 */
function onChangeUserName () {
    const element = document.getElementById("signup-username");
    element.classList.remove("login-form-input-error");
    if ( ! waitingForServerReply && element != null) {
        const userName = element.value;
        if (userName && enginesis.isValidUserName(userName)) {
            waitingForServerReply = true;
            enginesis.userGetByName(userName, onChangeUserNameServerResponse);
        } else {
            setUserNameIsUnique(false);
        }
    }
}

/**
 * Wait for the server to reply with our user name query.
 * @param {object} enginesisResponse Response object from service call.
 */
function onChangeUserNameServerResponse (enginesisResponse) {
    let userNameAlreadyExists = false;
    waitingForServerReply = false;
    if (enginesisResponse != null && enginesisResponse.fn != null) {
        userNameAlreadyExists = enginesisResponse.results.status.success == "1";
    }
    setUserNameIsUnique( ! userNameAlreadyExists);
}

/**
 * Update the user name visual status.
 * @param {boolean} isUnique True if the user name is unique, false if it is assigned to another account.
 */
function setUserNameIsUnique (isUnique) {
    const element = document.getElementById("username-unique");
    if (element != null) {
        if (isUnique) {
            element.classList.remove('username-is-not-unique');
            element.classList.add('username-is-unique');
            element.style.display = "inline-block";
        } else {
            element.classList.remove('username-is-unique');
            element.classList.add('username-is-not-unique');
            element.style.display = "inline-block";
        }
    }
}

/**
 * Watch for changes to the email address so we can verify it.
 */
function onChangeEmail(element, domIdImage) {
    const emailElement = document.getElementById("signup-email");
    emailElement.classList.remove("login-form-input-error");
    if ( ! waitingForServerReply && emailElement != null) {
        const emailAddress = emailElement.value;
        if (emailAddress && isValidEmail(emailAddress)) {
            waitingForServerReply = true;
            enginesis.userGetByEmail(emailAddress, onChangeEmailServerResponse);
        } else {
            setUserNameIsUnique(false);
        }
    }
}

/**
 * Wait for the server to reply with our email address query.
 * @param {object} enginesisResponse Response object from service call.
 */
function onChangeEmailServerResponse (enginesisResponse) {
    let emailAlreadyExists = false;
    waitingForServerReply = false;
    if (enginesisResponse != null && enginesisResponse.fn != null) {
        emailAlreadyExists = enginesisResponse.results.status.success == "1";
        const emailElement = document.getElementById("signup-email");
        if (emailAlreadyExists) {
            emailElement.classList.add("login-form-input-error");
        } else {
            emailElement.classList.remove("login-form-input-error");
        }
    }
}

/**
 * Dynamically assign event handlers once the page loads.
 */
function setupFormChangeHandlers () {
    let targetElement = document.getElementById("signup-username");
    if (targetElement != null) {
        targetElement.addEventListener("change", onChangeUserName);
        targetElement.addEventListener("input", onChangeUserName);
        targetElement.addEventListener("propertychange", onChangeUserName);
        onChangeUserName(targetElement, "signup-email"); // in case field is pre-populated
    }
    targetElement = document.getElementById("signup-email");
    if (targetElement != null) {
        targetElement.addEventListener("change", onChangeEmail);
        targetElement.addEventListener("input", onChangeEmail);
    }
    targetElement = document.getElementById("signup-show-password");
    if (targetElement != null) {
        targetElement.addEventListener("click", onClickRegisterShowPassword);
    }
}

/**
 * Handle any updates to the password input control.
 * @param {Event} event Browser Event object.
 */
function onClickRegisterShowPassword (event) {
    const passwordInput = document.getElementById("signup-password");
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
