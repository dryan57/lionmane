## Installation Guide

Clone repository from:

    https://github.com/dryan57/lionmane.git

Install Composer

Download from here (https://getcomposer.org/download/)

In your terminal, run the following command to install dependencies:

    $ composer install
    
In your terminal, run the following command to install front end dependencies

    $ npm install 

Creating a MySQL Database
Let's now create a MySQL database. In your terminal, run the following command to run the mysql client:

    $ mysql -u root -p
    
When prompted, enter the password for your MySQL server when you've installed it.

Next, run the following SQL statement to create a db database:

    mysql> create database contact;

Open the .env file and update the credentials to access your MySQL database:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=contact
    DB_USERNAME=root
    DB_PASSWORD=
    
At this point, you can run the migrate command to create your database and a bunch of SQL tables needed by our application:

    $ php artisan migrate

Run the following command to seed our data base with sample data:
    
    $ php artisan db:seed
    
This command will start a development server at http://localhost:8000:

    $ php artisan serve


