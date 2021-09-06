
## About Project

Simple restaurant management system created by Laravel.

- Back-end: Laravel Framework (Lucid template)
- Front-end: Bootstrap
- User Type: Admin, Staff (Manager, Cahsier, kitchen) and Andriod Clients
- Database: Mysql, Firebase Firestore
- FireStore: https://console.firebase.google.com/u/1/project/la-mesa-4cfae/firestore/data~2Frestaurants~2F1~2Forders~2FMOzX7NQgF2yBOR0CkThj
- Android Project: https://github.com/pyon123/Android-Ahmed-Firestore
- Requirements doc: https://docs.google.com/document/d/151tovB1aN5Pp6fCygexBckT4ljiwrUMwmF2-UIuBZEU/edit?usp=sharing

## Get Started

- composer install
- npm install (optional)
- add env file and configure it with your host name and database credentials
- Create Database on Mysql
- create tables: php artisan migrate --seed
    [seed file: database/seeds/RoleSeeder.php]
- run server in local: php artisan serve --host=192.168.2.3 --port=8000
- Admin login: [192.168.2.3/admin/login]
- Staff login: [192.168.2.3/login]
- Mobile endpoint: 192.168.2.3/mobile

## Referrence for Tech Stack

- Customized prebuilt user auth to multi user management system

    setting auth for admin and staff: 
    
    https://github.com/pyon123/LaMesa-Ahmed/blob/master/config/auth.php
    
    setting custome middleware: 
    
    https://github.com/pyon123/LaMesa-Ahmed/blob/master/app/Http/Middleware/Authenticate.php
    
    https://github.com/pyon123/LaMesa-Ahmed/blob/master/app/Http/Middleware/StaffLogin.php
    
    https://github.com/pyon123/LaMesa-Ahmed/blob/master/app/Http/Middleware/StaffManager.php
    
    https://github.com/pyon123/LaMesa-Ahmed/blob/master/app/Http/Middleware/StaffCashier.php
    
    https://github.com/pyon123/LaMesa-Ahmed/blob/master/app/Http/Middleware/StaffKitchen.php
    
 - Config staff role:
 
    https://github.com/pyon123/LaMesa-Ahmed/blob/master/config/roles.php



