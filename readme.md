StatusChecker
Steps to setup Status checker is : 



1-git clone . 




2 - in prodject run the following commends:

- composer install . // to install vendor// 

-cp .env.example .env //to generate .env file// 

- php artisan migrate .

- php artisan migrate:seeder --class=StatusTableSeeder

-php artisan ket:generate; 3 


- if jwt not install auto make the following :
- open composer.json in required and the following : "tymon/jwt-auth": "~1.0.0-rc.4.1" . 
after that go to https://github.com/tymondesigns/jwt-auth
