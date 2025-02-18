# inXys email templates

This folder holds all of the email templates. For each email there are 2 files: an HTML and a text file.

This is the definitive source of the email. Version and edit the files here. Make the text file match the content of the HTML file.

Test all edits in all browsers for all responsive device resolutions: desktop, tablet, phone.

When complete, copy the updated source files to ../../Enginesis/public/sites/109/email. You can use the node task
`npm run deployemail` to do this. Note these files are not version controlled in the Enginesis site
(they are .gitignore'd) so the source remains here but the source seen by users is on Enginesis
(it's really in the database.)

Once copied to Enginesis, run `npm run update-email`. This just minifies the HTML files. Sync the -d, -q, and live stages
so that they all have the exact same version of the files. You must get the final email source on the live server in order
to update the database.

Log in to the Enginesis CMS. Go to [Email Notifications](https://www.enginesis.com/admin/procs/manage_email.php).

- If you are creating a new email, click Create and fill out the form and save the data.
- If you are just updating one email then click edit and update the form and save the data.
- To update all the emails use the Batch Update. This will only update previously defined emails already registered.

## Create

To create a new email template select one of the email notification types. Not yet defined email notification types are selectable but
already defined are disabled. To edit an existing email you must select edit from the list.

Have prepared in advance the following:

Subject:
What will appear as the email subject.

Target URL:
When the user clicks the _call to action_ this is where to link the user.

Text message:
The complete message in text format (no HTML tags) that will be sent to users who selected text emails.

Text URL:
The URL on Enginesis.com where the complete source text file resides.

HTML message:
The complete message in HTML format that will be sent to users who selected HTML emails.

HTML URL:
The URL on Enginesis.com where the complete HTML source file resides.

## Tokens

Include the following tokens in the _subject_, _target URL_, _test message_, and _HTML message_:

`%date%`:
Formatted date at the time the email notification is generated.

`%site_id%`
Current site id (integer).

`%user_id%`
User id (integer) of the user the email is being sent to.

`%user_name%`
User name of the user the email is being sent to.

`%token%`
For some notifications, such as change password, a token is required to identify the authenticity of the returning user matches the request.

`%domain%`
The server host matching the site id (e.g. inxys.net).

`%title%`
Title of the article, conference, topic, or item description of the item that is being shared.

`%item_id%`
Item id (integer) of the item that is the subject of the notification (e.g. Share, Send to friend).

## Email catalog

Notification event           | Subject line                                     | Description
-----------------------------|--------------------------------------------------|------------
Send to friend / Follow user | Check out this item on inXys.net                 | User requests to follow another user.
✅ Change password          | Change Password Request from inXys.net           | User requested a password change.
✅ Forgot password          | Reset Password Request from inXys.net            | User requested a password change.
✅ Registration confirmation| Welcome to inXys.net - The Information Exchange  | Email sent when signing up a new account.
✅ Security update          | Account update from inXys.net                    | User updated their profile, confirmation.
Site newsletter              | Your latest news and updates from inXys.net      | Newsletter.
User Blocked                 | Your account is blocked at inXys.net             | User was blocked.
✅ System message           | Notification from inXys.net                      | A general system notification.
