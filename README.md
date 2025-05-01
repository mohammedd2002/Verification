
# 🛡️ Laravel Multi-Method Verification System

This project provides a comprehensive verification system using Laravel. It demonstrates multiple modern approaches to user verification for enhancing both **security** and **user experience**.

---

## 🔥 Features

- ✅ **Default Email Verification** – Laravel's built-in verification system.
- 🔐 **CVT (Code Verification Token)** – Custom dynamic token verification method.
- 🔑 **Passwordless Login** – Login via email link or token without using a password.
- 🔢 **OTP Verification** via:
  - Email
  - SMS using **Twilio**
  - Voice call using **Vonage**
- 🤖 **Google reCAPTCHA V2 & V3** – Bot protection for forms and login.

---

## 🛠️ Tech Stack

- Laravel 10.x
- Laravel Breeze
- Twilio API
- Vonage (Nexmo) API
- Google reCAPTCHA (v2 & v3)
- Laravel Notifications
- Custom Middleware & Validation


---

## 🚀 How to Run Locally

```bash
git clone https://github.com/your-username/verification.git
cd verification
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## 🔧 .env Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls

TWILIO_SID=your_twilio_sid
TWILIO_TOKEN=your_twilio_auth_token
TWILIO_FROM=+1XXXXXXXXXX

VONAGE_KEY=your_vonage_key
VONAGE_SECRET=your_vonage_secret

GOOGLE_RECAPTCHA_KEY=your_recaptcha_site_key
GOOGLE_RECAPTCHA_SECRET=your_recaptcha_secret_key
```



## 👤 Author

**Mohamed Abdelshakor**  
[LinkedIn Profile](https://www.linkedin.com/in/mohamed-abdelshakor-560029279)
