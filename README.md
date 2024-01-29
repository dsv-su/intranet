## 1. Overview
Production setup for DSV Intranet.

## 2. Requirements
Requirements are best determined using Server Requirements page of corresponding Laravel 10 version

- PHP version 8.1.*

- BCMath PHP Extension

- Ctype PHP Extension

- Fileinfo PHP extension

- JSON PHP Extension

- Mbstring PHP Extension

- OpenSSL PHP Extension

- PDO PHP Extension

- Tokenizer PHP Extension

- XML PHP Extension

- SSH access to the server

- Composer

## 3. Installation

* Make sure that composer is installed globally or install it in place

    * Clone the repository

        * Move into the directory. Move into the `/systemconfig` folder.

            * Make sure that `/systemconfig/internt.ini` file is present and configured with the configuration details for your requirements and for the server (copy play.ini.example to .ini and fill in with your data)

                    [global]
                    app_env=local                           ; Make sure this is set to local NOTE! For production enviroment the settings should be set to: app_env=production and app_debug=false.
                    app_debug=true                          ; Make sure this is set to true
                    app_url=http://localhost                ; Set this to localhost or your domain
                    authorization_parameter=entitlement     ; The authorization parameter NOTE! Not used for dev enviroments
                    authorization=                          ; Authorization entitlements NOTE! Not used for dev enviroments
                    login_route=/login                      ; The SSO login route for your application (The production server should be set ut with this route) 


                    [database]
                    db=mysql                                ; Here you can specify which database you use: mysql, sqlite, pgsql, sqlsrv or redis 
                    db_host=127.0.0.1                       ; DB host address
                    db_port=3306                            ; DB port
                    db_database=                            ; Database used     
                    db_username=                            ; DB user
                    db_password=                            ; secret

                    [sukat]                                 ; SUKAT OpenLDAP account credentials
                    host=
                    username=
                    password=
                    port=636
                    base_dn=
                    timeout=5
                    version=3


* Make sure the subdirectories
  `bootstrap/cache` and `/storage` is writable by your web server user.

Make sure these folder exist or create these folders under storage/framework:

    sessions 
    views
    cache

* Once the global settings are entered you can install the dependencies. `composer install`

    * Make sure that .env file is present (copy .env.example to .env). If you are setting up a dev enviroment add the following settings to the .env file:


    EMULATE_IDP=true
    SHIBB_NAME=Shib-cn
    SHIBB_FNAME=Shib-givenName
    SHIBB_LNAME=Shib-sn
    SHIBB_EMAIL=Shib-mail
    SHIBB_EMPLID=Shib-emplId

    LOG_CHANNEL=daily

    LDAP_CACHE=true


* Either create application key manually or do that with a command `php artisan key:generate`

* If you need to change the email configuration. Open the .env file and set the needed values

* Create the database with `php artisan migrate` (this should create database tables needed)


## 4. Building assets (dev)

Make sure you have updated npm to the latest version

    npm update -g

Install the dependecies

    npm install

Build the development assets by running

    npm run dev

For production build the production assets

    npm run build
