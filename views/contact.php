<?php
$hackerVerification = generateHackerVerificationCode();
?>
<form id="contact-form" method="POST" action="/contact/">
    <div class="login-form p-3">
        <h3 class="text-center">Contact us:</h3>
        <div>
            <label for="contact_username">Your name:</label><br>
            <input type="text" id="contact_username" name="contact_username" tabindex="16" maxlength="20" class="form-control login-form-input required" autocorrect="off" autocomplete="name" aria-describedby="name-success-status"/>
        </div>
        <div>
            <label for="contact_email">Your email:</label><br>
            <input type="email" id="contact_email" name="contact_email" tabindex="17" maxlength="20" class="form-control login-form-input required" autocorrect="off" autocomplete="name"/>
        </div>
        <div>
            <label for="contact_message">Your message:</label><br>
            <textarea class="form-control required" id="contact_message" tabindex="18" rows="3"></textarea>
        </div>
        <div class="p-3">
            <button type="submit" class="btn btn-lg btn-success" value="contactButton" name="contactButton" id="contactButton" tabindex="19">Send</button>
            <input type="hidden" name="all-clear" value="<?php echo($hackerVerification);?>" />
            <input type="hidden" name="action" value="contact" />
        </div>
    </div>
</form>
<div class="modalMessageArea"></div>
