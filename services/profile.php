<?php /** profile page support functions
 * Support functions for page /profile/index.php and sub-pages.
 * @author jf 05/12/2025
 */

 /**
  * A redirect from regconfirm.php so we can complete registration and display any error message.
  * @param string $registrationErrorCode Return an error code or success indicating the result of the registration confirmation.
  * @param string $redirectedStatusMessage Return a user-facing message indicating the result of the registration confirmation.
  */
function completeUserRegistration( & $registrationErrorCode, & $redirectedStatusMessage) {
    $registrationErrorCode = getPostOrRequestVar('code', '');
    if ($registrationErrorCode == 'NO_ERROR' || $registrationErrorCode == 'SUCCESS' || $registrationErrorCode == '') {
        $registrationErrorCode = 'SUCCESS';
        $redirectedStatusMessage = $stringTable->lookup(EnginesisUIStrings::WELCOME_MESSAGE, null);
        // @todo: Verify the cookie/token matches this user
        // @todo: There should be a safeguard if a hacker comes with action+code but is really not the user we think he is spoofing
        $userInfo = $enginesis->getLoggedInUserInfo();
        $isValidSession = verifySessionIsValid($userId, $authToken);
        $isLoggedIn = true;
        $authToken = $userInfo->authtok;
        $refreshToken = $userInfo->refresh_token;
        $refreshTokenExpires = $userInfo->expires;
        $userId = $userInfo->user_id;
        $enginesis->userLoginRefresh();
        $errorCode = completeUserActivation($userInfo);
    } else {
        // regconfirm failed for some reason so ask the user to do something about it.
        $userUserId = getPostOrRequestVar('u', '');
        $userName = getPostOrRequestVar('n', '');
        $userEmail = getPostOrRequestVar('e', '');
        $confirmationToken = getPostOrRequestVar('t', '');
        $linkToResendToken = createResendConfirmEmailLink($userUserId, $userName, $userEmail, $confirmationToken);
        $redirectedStatusMessage = errorToLocalString($registrationErrorCode);
    }
}

/**
 * called from login when the user has not confirmed their email with https://inxys-l.net/profile/?action=resendconfirm&n=jim&d=1745976307
 * u=user-id, n=user-name, e=email, t=token, d=timestamp
 * if u || n || e, then look up account info and determine if not confirmed. if not confirmed, resend the email.
 * @param string $registrationErrorCode Return an error code or success indicating the result of the look up.
 * @param string $redirectedStatusMessage Return a user-facing message indicating the result of the look up.
 */
function resendConfirmationNotification( & $registrationErrorCode, & $redirectedStatusMessage) {
    $userUserId = getPostOrRequestVar('u', '');
    $userName = getPostOrRequestVar('n', '');
    $userEmail = getPostOrRequestVar('e', '');
    $confirmationToken = getPostOrRequestVar('t', '');
    $results = $enginesis->registeredUserResetSecondaryPassword($userUserId, $userName, $userEmail, $confirmationToken);
    if (empty($results)) {
        // most likely the parameters are incorrect and the user lookup failed.
        $errorResponse = $enginesis->getLastError();
        $registrationErrorCode = $errorResponse['message'];
        $redirectedStatusMessage = $stringTable->lookup(EnginesisUIStrings::REG_CONFIRM_ERROR, null); // . ' ' . $errorResponse['extended_info'];
    }
}

/**
 * User requested a password reset, this function completes the process.
 * @param string $errorCode Return an error code or success indicating the result of the look up.
 * @param string $statusMessage Return a user-facing message indicating the result of the look up.
 */
function resetPassword( & $errorCode, & $statusMessage) {
    $errorCode = '';
    $statusMessage = '';
}

/**
 * User requested to view the profile of another user.
 * @param string $errorCode Return an error code or success indicating the result of the look up.
 * @param string $statusMessage Return a user-facing message indicating the result of the look up.
 */
function viewUserProfile( & $errorCode, & $statusMessage) {
    $userUserId = getPostOrRequestInt(['u', 'user', 'id'], 0);
    // look up user, return public attributes
    $errorCode = '';
    $statusMessage = '';
}
