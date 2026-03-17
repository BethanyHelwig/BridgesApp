<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Prerequisites

The following must already be installed on your computer:
- Postgres
- Laravel
- Composer
- Have a local Postgres database initialized

## Installation

Change the ".env.example" file to just ".env." Inside, you will need to input the 
DB_DATABASE, DB_USERNAME, and DB_PASSWORD to reference your own local instance of postgres.

Next, use terminal/CLI to move to the directory and run the following
- 'npm install'
- 'composer install'
- 'php artisan key:generate' (NOTE: you must change the .env.example to .env first)
- 'php artisan migrate --seed' (NOTE: .env must contain your DB information first)

To start, use terminal/CLI to move to the directory of the project and run "composer run dev"

The API endpoint to access data by State and/or zip, is http://localhost:8000/getCountiesCities.
You can easily submit requests via the interface of the main page of http://localhost:8000 
or send parameters directly to the specified URL.