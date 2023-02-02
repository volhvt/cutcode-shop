# CUTCODE SHOP


## for local develop
(all actions from root of git project)
- $> `cp ./docker/mysql/docker-entrypoint-initdb.d/createdb.sql.example ./docker/mysql/docker-entrypoint-initdb.d/createdb.sql`
- if you need restore db backup, put dump sql file to ./docker/mysql/docker-entrypoint-initdb.d as filldb.sql
- $> `cp ./environments/localhost/.env.common ./.env`
- $> `cp ./environments/localhost/.env.common ./sources/.env`
- $> `cat ./environments/localhost/.env.docker >> ./.env`
- $> `cat ./environments/localhost/.env.app >> ./sources/.env`
- change needed params in .env file
- $> `cp ./environments/localhost/docke-compose.override.yml ./docker-compose.override.yml`
- $> `docker-compose build`
- $> `docker-compose up -d`
- $> `docker-compose exec php-fpm bash`
- $> `composer install`


## installation
- $> `php artisan key:generate`
- $> `php artisan shop:install`

 
