# inXys to-do

Catalog to-do tasks here.

Any tasks that are specified fully and determined to be worked on should go to [issues](https://github.com/VarynInc/inxys/issues).

🏓 - in-progress
✅ - complete
🟦 - backlog
🐛 - bug report
🔴 - high priority

### Test accounts

- 10589 inXys-admin
- 10597 Jim
- 10598 jf
- 10599 Murray 987pipesmoke123

zamb33ZEE4269&&

- 🟦 Create user: on successful confirmation then create 1 public conference for this user (profile/index.php)
- 🟦 Log in, if not confirmed offer resend link
- 🟦 Log in, if BLOCKED or other error do not show resend confirm
- 🟦 Log in, rememberme sets cookie. if rememberme is not checked then the cookie only lasts for the session until closed
- 🟦 add Send Again on login page if log in but unconfirmed ** Do also for Varyn. If user logs in but in not confirmed, offer to resend the confirm email.
- 🟦 forgot password form
- 🟦 reset password form
- 🟦 Profile page
    - Edit profile
    - Upload avatar image - UI to crop/scale image and then upload it to server and set on user account
    - show avatar
    - show user activity feed
    - preferences
    - edit profile (name, nickname, email, password, profile image)
- 🟦 Scratchpad
    - List scratchpads, list by date, tags, title
    - create new
    - edit/update
    - markdown editor like Medium
- 🟦 Conference
    - loggedin: List all, member of ConferenceList ConferenceList(IN _site_id int, in _logged_in_user_id int, in _tags varchar(50), in _start_date datetime, in _end_date datetime, in _start_item int, in _num_items int, in _include_public_non_member int, in _language_code char(2), OUT _success boolean, OUT _status_msg varchar(255))
    - not logged in: list all public (SiteConferenceList)SiteConferenceList(IN _site_id int, in _logged_in_user_id int, in _tags varchar(50), in _start_date datetime, in _end_date datetime, in _start_item int, in _num_items int, in _public_only tinyint, in _has_member_id int, in _language_code char(2), OUT _success boolean, OUT _status_msg varchar(255))
    - list membership
    - add/remove member
    - create new
    - edit/update
    - comment

- ✅ Log in, verify correct account match (cr), set login cookie
- ✅ Log in, add show password
- ✅ Log out
- ✅ Get Sign up working
    - Load email notifications in database (regConfirm, systemMessage, forgotPassword, changePassword, securityUpdate, accountChange)
    - send verification email
    - return link from email (regconfirm) on /profile page
    - onchange handler for name must be valid and unique to remove class "login-form-input-error"
    - onchange handler for email must be valid and unique, to remove class "login-form-input-error"
    - onchange handler for password must be valid to remove class "login-form-input-error"
    - verify agreement
    - handle sign up error (name in use, email in use, other errors?)
- ✅ Menu not logged in: Home (sign in/sign up), Conferences (Public), Users (public), Sign up, Search, About
- ✅ Menu logged in: Home (feed), Conferences (Public & Private), Users (public), Profile, Search, About
- ✅ All build commands
  - build ✅
  - clean ✅
  - deploy ✅
  - deployemail ✅
  - lint ✅
  - sitemap ✅
  - start ✅
  - test ✅
  - updatemodules ✅
  - versionup ✅
