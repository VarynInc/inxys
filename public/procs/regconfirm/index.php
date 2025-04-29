<?php /** Confirm a new user registration
 * Handle registration confirmation from email request. The link in the email redirects to here, we use the parameters
 * u (user-id), s (site-id), and t (token, or secondary-password) to verify this is the user. Once confirmed the
 * user is logged in. If not confirmed a reason message is displayed. All cases redirect to /profile with the
 * error code and the message is displayed there.
 * @author jf 2016-01-15
 * @param integer `u` is the user-id to confirm.
 * @param integer `s` is the site-id.
 * @param string `t` is the token generated at sign up that is required to match the user-id.
 */
require_once('../../../services/inxys_common.php');
$page = 'profile';
processTrackBack();
$user_id = getPostOrRequestVar('u', 0);
$site_id = getPostOrRequestVar('s', 0);
$token = getPostOrRequestVar('t', '');
$redirectTo = '/profile/?action=regconfirm&code=';
$errorCode = '';

if ($site_id == ENGINESIS_SITE_ID && isValidId($user_id) && ! empty($token)) {
    $errorCode = '';
    $serverResponse = $enginesis->registeredUserConfirm($user_id, $token);
    if ($serverResponse == null) {
        $errorCode = $enginesis->getLastErrorCode();
    } else {
        $errorCode = 'SUCCESS&u=' . $user_id . '&t=' . $token;
    }
} else {
    $errorCode = 'INVALID_PARAM';
}
header('Location: ' . $redirectTo . $errorCode);
return;
