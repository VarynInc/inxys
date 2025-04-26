<?php
$hackerVerification = makeInputFormHackerToken();
$userName = strip_tags(getPostVar('signup-username', ''));
$password = strip_tags(getPostVar('signup-password', ''));
$email = strip_tags(getPostVar('signup-email', ''));
$agreeToTerms = getPostVar('agree-terms', '');
$agreeChecked = $agreeToTerms == 'on' ? 'checked' : '';
$rememberMe = getPostVar('rememberme', '');
$rememberMeChecked = $rememberMe == 'on' ? 'checked' : '';
?>
<form id="signup-form" name="signup-form" method="POST" action="/signup/">
    <div class="login-form p-3">
        <h3 class="text-center">Join us:</h3>
        <div class="form-group has-warning has-feedback">
            <label for="signup-username">User name:</label><br>
            <input type="text" id="signup-username" name="signup-username" tabindex="16" maxlength="20" class="login-form-input required" autocorrect="off" autocomplete="name" required aria-describedby="name-success-status" value="<?php echo($userName);?>"/>
            <span id="username-unique" class="username-is-not-unique"></span>
            <div class="signup-form-error" id="username-error"></div>
        </div>
        <div class="form-group">
            <label for="signup-email">Email:</label><br>
            <input type="email" id="signup-email" name="signup-email" tabindex="17" maxlength="20" class="login-form-input required" autocomplete="email" required value="<?php echo($email);?>"/>
            <span id="email-unique" class="username-is-not-unique"></span>
            <div class="signup-form-error" id="email-error"></div>
        </div>
        <div class="form-group">
            <label for="signup-password">Password:</label><br>
            <input type="password" id="signup-password" name="signup-password" tabindex="18" maxlength="32" class="login-form-input required password" placeholder="A secure password" autocomplete="current-password" autocorrect="off" required value="<?php echo($password);?>"/>
            <span id="signup-show-password" class="showPasswordButton" style="margin-top: 1rem;" tabindex="19"><span id="show-password-text">Show</span> <span id="show-password-icon" class="iconEye" aria-hidden="true"></span></span>
            <div class="signup-form-error" id="password-error"></div>
        </div>
        <div class="form-group p-2>
            <span id="agree-terms-group"><input type="checkbox" tabindex="20" name="agree-terms" id="agree-terms" <?php echo($agreeChecked);?>><label for="agree-terms"> &nbsp;&nbsp;I agree with the terms of service</label></span>
        </div>
        <div class="form-group m-2 p-2 text-center">
            <input type="submit" class="btn btn-lg btn-success" tabindex="21" value="Join" name="signupButton" id="signupButton"/>
            <input type="hidden" name="all-clear" value="<?php echo($hackerVerification);?>" />
            <input type="hidden" name="action" value="signup" />
        </div>
        <div class="text-center">
            <span id="rememberme-container" style="padding: 0 1rem;"><input type="checkbox" tabindex="22" <?php echo($rememberMeChecked);?> name="rememberme" id="rememberme"><label for="rememberme">&nbsp;&nbsp;Remember Me</label></span>
            <a href="/terms/" target="_new" class="right" tabindex="23">Terms of service</a> |
            <a href="/privacy/" target="_new" class="right" tabindex="24">Privacy policy</a>
        </div>
    </div>
</form>
