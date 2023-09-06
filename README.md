## INSTALLATION GUIDE
## Requirements
 - PHP 8.2.10
 - Node v18.17.1

---
### Step 1
Create database using PhpMyAdmin

### Step 2
Setup your env file. In command line type
`cp .env.example .env`
`php artisan key:generate`
after this change database name in env `DB_DATABASE=[database_name_you_created]`

### Step 3
Type this in your command line to populate the database
`php artisan migrate`
`php artisan db:seed`
`composer install`
`npm install`

### Step 4
Open two command line to connect to server.
CLI 1: `php artisan serve`
CLI 1: `npm run dev`

### Step 5
You can now access the application using this url: http:http://localhost:8000/
You can login now using this credential below
Username: `testuser`
Email: `test@example.com`
Password: `password`
