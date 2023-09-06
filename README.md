## INSTALLATION GUIDE
## Requirements
 - PHP 8.2.10
 - Node v18.17.1

---
### Step 1
Create database using PhpMyAdmin

### Step 2
Setup your env file. In command line type <br>
`cp .env.example .env` <br>
`php artisan key:generate` <br>
after this change database name in env `DB_DATABASE=[database_name_you_created]`

### Step 3
Type this in your command line to populate the database <br>
`php artisan migrate` <br>
`php artisan db:seed` <br>
`composer install` <br>
`npm install`

### Step 4
Open two command line to connect to server. <br>
CLI 1: `php artisan serve` <br>
CLI 1: `npm run dev`

### Step 5
You can now access the application using this url: http:http://localhost:8000/ <br>
You can login now using this credential below <br>
Username: `testuser` <br>
Email: `test@example.com` <br>
Password: `password`
