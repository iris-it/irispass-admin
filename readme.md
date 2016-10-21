# Irispass ( admin section )

[![Build Status](https://travis-ci.org/iris-it/irispass-admin.svg?branch=master)](https://travis-ci.org/iris-it/irispass-admin)

Irispass is an open source projet who aims to help compagnies to build their IT quickly by providing many tools quickly :
 - User management
 - Group management
 - File management ( and advanced sharing )
 - CRM ( [iris-crm](https://github.com/iris-it/iris-crm) )
 - Mail client ( not now )
 - Virutal Desktop to open all apps in one place ( [irispass-desktop](https://github.com/iris-it/irispass-desktop)
 - A Chat to discuss with the teams ( not now )
 - deploy small websites for companies (custom version of typesetter cms)
 
 
The authentication is provided by the Keycloak Server ( [Jboss Keycloak](http://www.keycloak.org/) ) it is easy to use and easy to deploy, it provides with irispass: SSO in all apps, user management and sync between apps and social login if you need.

Irispass admin and CRM uses [eloquent-oauth-l5](https://github.com/adamwathan/eloquent-oauth-l5) for the authentication.

For the authorization part, its a custom part with a parser and a crud, you only need to assign a role to an user and set permissions in the code with a small pattern in the name and run a command to get all your permissions synced in the database.

Many services are useds in laravel in order to talk with keycloak, create and manage a filesystem for file sharing (needs lot of improvement) or deploy small websites (need more versatility)

# contribution
for now, the project is not easy to setup or test, so i will improve this quicly
i will write a documentation for this project and make many improvements in order to deploy it on docker, marathon, etc etc

# development
Requirements :
- keycloak server, up and running ( you can change it for an another oauth provider, look the doc for [eloquent-oauth-l5](https://github.com/adamwathan/eloquent-oauth-l5))
- stack for laravel ( lamp )

Install:
- clone the projet
- composer install
- npm install
- gulp
- php artisan migrate --seed
- php artisan parse:permissions

And you are good to go but don't make issues for saying "not work", "why keycloak", etc etc, this a very experimental projet, not everything is tested and can work without components ( os.js, typesetter, keycloak ) i will try to make this project modular but now i cant !
