# PHP Session Auto Logout Demo

## 📌 Description
This project is a simple PHP session-based login system that demonstrates
automatic logout using a session timeout and a countdown timer.

It is mainly used to understand how web sessions work and how users are
logged out after a fixed amount of time.

---

## 🎯 Objective
The main goal of this project was to:

- Use PHP sessions for authentication
- Set a session lifetime of **30 seconds**
- Display logged-in user information (**Tiger**)
- Show a live countdown timer on the dashboard
- Automatically log the user out when the timer reaches zero
- Redirect the user to a logout page
- Provide a manual logout button
- Ensure the timer does **not reset** on page refresh

---

## 📂 Project Files

### `login.php`
- Starts a session
- Logs in the user as **Tiger**
- Sets the session expiration time (30 seconds)
- Redirects the user to `index.php`

### `index.php`
- Protected page (requires login)
- Displays user information
- Shows a live countdown timer
- Automatically logs the user out when time expires
- Redirects to `out.php`

### `logout.php`
- Destroys the session manually
- Redirects to `out.php`

### `out.php`
- Displays a red message: **"You are logged out"**
- Ensures the session is destroyed
- Provides a link to log in again

---

## ⏱️ Session Rules
- Total session duration: **30 seconds**
- Countdown updates every second
- Auto logout occurs when:
  - The timer reaches zero
  - The logout button is clicked

---

## ⚠️ Known Issues / Errors

### Timer behavior
- If the page is refreshed very close to zero seconds, the user may be logged out immediately.
  This is expected behavior.

### Redirect issues
- If the system redirects directly to `out.php`, it may be due to:
  - Old session data
  - Browser cookies not cleared

**Solution:**
- Clear browser cookies for `localhost`
- Restart Apache (XAMPP)
- Reload `login.php`

### JavaScript disabled
- If JavaScript is disabled, the countdown timer will not display.
- The session will still expire server-side after 30 seconds.

---

## ▶️ How to Run
1. Place all files in one folder (example: `htdocs/session_demo`)
2. Start Apache using XAMPP
3. Open a browser and go to:
