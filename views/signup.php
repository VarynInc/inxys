<form id="signup-form" method="POST" action="/signup/">
    <div class="login-form">
        <h3 class="text-center">Join us:</h3>
        <div class="form-group has-warning has-feedback">
            <label for="signup_username">User name:</label><br>
            <input type="text" id="signup_username" name="signup_username" tabindex="16" maxlength="20" class="login-form-input required" autocorrect="off" autocomplete="name" aria-describedby="name-success-status"/>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
            <span id="name-success-status" class="sr-only">(success)</span>
        </div>
        <div class="form-group">
            <label for="signup_email">Email:</label><br>
            <input type="email" id="signup_email" name="signup_email" tabindex="17" maxlength="20" class="login-form-input required" autocorrect="off" autocomplete="name"/>
        </div>
        <div class="form-group">
            <label for="signup_email">Email:</label><br>
            <span id="agree_terms_group"><input type="checkbox" tabindex="20" name="agree_terms" id="agree_terms"><label for="agree_terms"> &nbsp;I agree with the terms of service</label></span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-success" value="signupButton" name="signupButton" id="loginButton">Join</button>
            <input type="hidden" name="all-clear" value="<?php echo($hackerVerification);?>" />
            <input type="hidden" name="action" value="signup" />
        </div>
        <div class="text-center">
            <a href="/terms/" target="_new" class="right">Terms of service</a> |
            <a href="/privacy/" target="_new" class="right">Privacy policy</a>
        </div>
    </div>
</form>
<div class="modalMessageArea"></div>
