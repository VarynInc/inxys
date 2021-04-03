<form id="login-form" method="POST" action="index.php">
    <div class="login-form">
        <h3 class="text-center">Welcome!</h3>
        <div class="form-group">
            <label for="login_username">Name or number:</label><br>
            <input type="text" id="login_username" name="login_username" tabindex="17" maxlength="20" class="login-form-input required" autocorrect="off" autocomplete="name"/>
        </div>
        <div class="form-group">
            <label for="login_password">Password:</label><br>
            <input type="password" id="login_password" name="login_password" tabindex="18" maxlength="20" class="login-form-input required" />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-success" value="loginButton" name="loginButton" id="loginButton">Login</button>
            <input type="hidden" name="all-clear" value="<?php echo($hackerVerification);?>" />
            <span id="rememberme-container"><input type="checkbox" tabindex="20" checked="checked" name="rememberme" id="rememberme"><label for="rememberme">Remember Me</label></span>
            <div class="text-right">
                <a id="loginPopup_forgot_password" href="/forgotpassword/" tabindex="21">Forgot password?</a>
            </div>
            <input type="hidden" name="action" value="login" />
        </div>
    </div>
</form>
<div class="modalMessageArea"></div>