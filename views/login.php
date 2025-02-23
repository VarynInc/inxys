<?php
$hackerVerification = makeInputFormHackerToken();
$userName = strip_tags(getPostVar('login-username', ''));
$password = strip_tags(getPostVar('login-password', ''));
$rememberMe = getPostVar('rememberme', '');
$rememberMeChecked = $rememberMe == 'on' ? 'checked' : '';
?>
<form id="login-form" method="POST" action="index.php">
    <div class="login-form">
        <h3 class="text-center">Welcome!</h3>
        <div class="form-group">
            <label for="login_username">Name or number:</label><br>
            <input type="text" id="login-username" name="login-username" tabindex="17" maxlength="50" class="login-form-input required" autocorrect="off" autocomplete="name" value="<?php echo($userName);?>"/>
        </div>
        <div class="form-group">
            <label for="login_password">Password:</label><br>
            <input type="password" id="login-password" name="login-password" tabindex="18" maxlength="32" class="login-form-input required" value="<?php echo($password);?>"/>
        </div>
        <div class="form-group p-3">
            <button type="submit" class="btn btn-lg btn-success" value="loginButton" name="loginButton" id="loginButton" tabindex="19">Login</button>
            <input type="hidden" name="all-clear" value="<?php echo ($hackerVerification); ?>" />
            <div>
                <span id="rememberme-container"><input type="checkbox" tabindex="20" <?php echo($rememberMeChecked);?> name="rememberme" id="rememberme"><label for="rememberme">Remember Me</label></span>
                <a id="loginPopup_forgot_password" href="/procs/forgotpass/" tabindex="21" style="float:right;">Forgot password?</a>
            </div>
            <input type="hidden" name="action" value="login" />
        </div>
    </div>
</form>
