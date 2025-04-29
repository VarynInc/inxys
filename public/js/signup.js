/**
 * Client-side registration/sign up form logic. Tried to do client-side form implementation
 * and validation before sending to the server.
 */
import enginesis from "/js/enginesis.js";
import enginesisConfig from "/js/enginesisConfig.js";
let waitingForServerReply = false;

/**
 * Watch for changes to the user name so we can verify it.
 */
function onChangeUserName () {
    const element = document.getElementById("signup-username");
    if (element != null) {
        element.classList.remove("login-form-input-error");
        const userName = element.value;
        if (userName && enginesis.isValidUserName(userName)) {
            if ( ! waitingForServerReply) {
                waitingForServerReply = true;
                enginesis.userGetByName(userName, onChangeUserNameServerResponse);
            }
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
    if (enginesisResponse != null && enginesisResponse.fn == "UserGetByName") {
        userNameAlreadyExists = enginesisResponse.results.status.success == "1";
    }
    setUserNameIsUnique( ! userNameAlreadyExists);
    document.getElementById("username-error").innerText = userNameAlreadyExists ? signUpErrors["REGISTRATION_NAME_IN_USE"] : "";
}

/**
 * Update the user name visual status.
 * @param {boolean} isUnique True if the user name is unique, false if it is assigned to another account.
 */
function setUserNameIsUnique (isUnique) {
    const element = document.getElementById("username-unique");
    if (element != null) {
        if (isUnique) {
            element.classList.remove("username-is-not-unique");
            element.classList.add("username-is-unique");
        } else {
            element.classList.remove("username-is-unique");
            element.classList.add("username-is-not-unique");
        }
        element.style.display = "inline-block";
    }
}

/**
 * Update the user email visual status.
 * @param {boolean} isUnique True if the email is unique, false if it is assigned to another account.
 */
function setEmailIsUnique (isUnique) {
    const element = document.getElementById("email-unique");
    if (element != null) {
        if (isUnique) {
            element.classList.remove("username-is-not-unique");
            element.classList.add("username-is-unique");
        } else {
            element.classList.remove("username-is-unique");
            element.classList.add("username-is-not-unique");
        }
        element.style.display = "inline-block";
    }
}

/**
 * Determine if the is-unique class is assigned to a given element in order to determine
 * if that value has passed validation.
 * @param {string} id DOM element id.
 * @returns {boolean} True if the element has the is-unique class, false if it does not.
 */
function formValueIsUnique(id) {
    const element = document.getElementById(id);
    if (element != null) {
        return element.classList.contains("username-is-unique");
    }
    return false;
}

/**
 * Watch for changes to the email address so we can verify it.
 */
function onChangeEmail() {
    const emailElement = document.getElementById("signup-email");
    emailElement.classList.remove("login-form-input-error");
    if ( ! waitingForServerReply && emailElement != null) {
        const emailAddress = emailElement.value;
        if (emailAddress && enginesis.isValidEmail(emailAddress)) {
            waitingForServerReply = true;
            enginesis.userGetByEmail(emailAddress, onChangeEmailServerResponse);
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
           document.getElementById("email-error").innerText = signUpErrors["REGISTRATION_EMAIL_IN_USE"];
        } else {
            emailElement.classList.remove("login-form-input-error");
            document.getElementById("email-error").innerText = "";
        }
        setEmailIsUnique( ! emailAlreadyExists);
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
    targetElement = document.getElementById("signup-form");
    if (targetElement != null) {
        targetElement.addEventListener("submit", validateSignupForm);
    }
}

/**
 * Toggle the show password form input.
 * @param {Event} event Browser Event object.
 */
function onClickRegisterShowPassword (event) {
    const passwordInput = document.getElementById("signup-password");
    const icon = document.getElementById("show-password-icon");
    const text = document.getElementById("show-password-text");
    const show = icon.classList.contains("iconEyeSlash");

    if (show) {
        passwordInput.type = "password";
        icon.className = "iconEye";
        text.innerText = "Show";
    } else {
        passwordInput.type = "text";
        icon.className = "iconEyeSlash";
        text.innerText = "Hide";
    }
}

function setFormErrorMessage(errorMessage) {
    const container = document.getElementById("signup-form-container");
    if (container) {
        const existingElement = container.getElementsByClassName("modalMessageArea");
        let errorElement;
        if (existingElement.length == 0) {
            errorElement = document.createElement("div");
            errorElement.classList.add("modalMessageArea");
            container.insertBefore(errorElement, container.children[0]);
        } else {
            errorElement = existingElement[0];
        }
        errorElement.innerHTML = `<div class="modalMessageArea"><p class="text-error">${errorMessage}</p></div>`;
    }
}

/**
 * Determine if the sign up form is good enough to send to the server. Iterate over each form
 * input to determine if it acceptable to send to the server, and if not update the form to
 * give the user feedback.
 * @param {Event} event Event details.
 * @returns true if form is submittable, false if error requires user intervention.
 */
function validateSignupForm(event) {
    const signupForm = document.forms["signup-form"];
    let errorCount = 0;

    function setErrorIfInvalid(isInvalid, signUpFormElement, messageElementId, errorCode) {
        if (isInvalid) {
            errorCount += 1;
            signUpFormElement.classList.add("login-form-input-error");
            document.getElementById(messageElementId).innerText = signUpErrors[errorCode];
        }
    }

    // has name is unique and is acceptable
    let formId = "signup-username";
    if (formValueIsUnique("username-unique")) {
        setErrorIfInvalid( ! enginesis.isValidUserName(signupForm[formId].value), signupForm[formId], "username-error", "REGISTRATION_INVALID");
    } else {
        errorCount += 1;
    }
    // has email is unique and is acceptable
    formId = "signup-email";
    if (formValueIsUnique("email-unique")) {
        setErrorIfInvalid( ! enginesis.isValidEmail(signupForm[formId].value), signupForm[formId], "email-error", "INVALID_EMAIL");
    } else {
        errorCount += 1;
    }
    // has password and is acceptable
    formId = "signup-password";
    setErrorIfInvalid( ! enginesis.isValidPassword(signupForm[formId].value), signupForm[formId], "password-error", "REGISTRATION_INVALID_PASSWORD");
    // must agree to terms of use
    if ( ! signupForm["agree-terms"].checked) {
        errorCount += 1;
        setFormErrorMessage(signUpErrors["REGISTRATION_TOS"]);
    } else if (errorCount > 0) {
        setFormErrorMessage(signUpErrors["REGISTRATION_INCOMPLETE"]);
    }
    if (errorCount > 0) {
        event.preventDefault();
        return false;
    } else {
        // disable Join button and submit the form.
        const joinButton = document.getElementById("signupButton");
        joinButton.classList.add("disabled");
        joinButton.disabled = true;
        return true;
    }
}

enginesis.init(enginesisConfig);
setupFormChangeHandlers();
