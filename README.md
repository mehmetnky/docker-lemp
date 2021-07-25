# Docker - LEMP Stack Dev Environment

This is a ready-to-fire LEMP Stack development environment. All services created using official images, you can reach them via those links:

[MySql](https://hub.docker.com/_/mysql) - 
[PhpMyAdmin](https://hub.docker.com/_/phpmyadmin) - 
[Nginx](https://hub.docker.com/_/nginx) - 
[PHP Official Image](https://hub.docker.com/_/php) - [Version of php-fpm used in this stack](https://hub.docker.com/layers/php/library/php/fpm/images/sha256-6d653e2ff0e2fdce1590afeb5f4b011f07919f8db120f8d82437edd4fe4fc3e3?context=explore)

## How to use
First of all, you need to go through [Docker Installation](https://docs.docker.com/get-docker/) but I suppose you already did that so you can follow steps below.

- To start up MySql and PhpMyAdmin services, navigate to `/db/` folder and type `docker-compose up -d`.
- Now navigate to `/front/` folder and type the same command `docker-compose up -d`. It could take several seconds php-fpm service to startup.

And now you can use PhpMyAdmin from http://localhost:8888/ to create, delete and whatever you want to do with your MySql database (username: `root` password: `1234`). 

Edit files in `/front/html/` directory and see the changes from http://localhost:80/ for `index.php` and http://localhost:80/index.html for `index.html`. 

When you type `docker ps` command, you should see your containers like this:

CONTAINER ID|IMAGE|COMMAND|CREATED|STATUS|PORTS|NAMES|
|-|-|-|-|-|-|-|
|[some random id]|nginx|"/docker-entrypoint.…"|[some seconds ago]|[some seconds]|0.0.0.0:80->80/tcp, :::80->80/tcp|nginx|
|[some random id]|php:fpm|"docker-php-entrypoi…"|[some seconds ago]|[some seconds]|9000/tcp|php-fpm|
|[some random id]|phpmyadmin|"/docker-entrypoint.…"|[some seconds ago]|[some seconds]|0.0.0.0:8888->80/tcp, :::8888->80/tcp|phpmyadmin|
|[some random id]|mysql|"docker-entrypoint.s…"|[some seconds ago]|[some seconds]|3306/tcp, 33060/tcp|mysql|

## How It works?

Services have some requirements to startup, those requirements are specified in environment rest of them are mostly optional.

Be aware that in `docker-compose.yml` files we set `container_name` vars to easen communication between containers. With this technique, we can refer to containers like `[container_name]:[port]` as in `/front/default.conf` file.

### MySql & PhpMyAdmin
		
- `MYSQL_ROOT_PASSWORD` should be the same in both `mysql` and `phpmyadmin` services and both `container_name` in `mysql` and `PMA_HOST` in `phpmyadmin` variables should be the same.
- `restart: always` is optional. If some kind of exception happens, those services will restart itself.
- Both services should be in the same network so they can communicate to each other easily, via their container names & ports.
- Volumes in **mysql** is also optional. If you create and specify a volume, **mysql** won't lose It's stored data.

### Nginx & Php-fpm

- Both services should be in the same network so they can communicate to each other easily, via their container names & ports.
- **phpfpm** service must be in the same network with **mysql** so you can make sql queries easily.
- You should bind your project root directory to `/var/www/html` as volume. In this case, we set the volume like this `./html:/var/www/html` for **phpfpm** service and `./html:/usr/share/nginx/html` for **nginx** service.
- For **php-fpm** service, we wrote a command to install **mysqli** extension. If you're not gonna use **mysqli** or use a different php extension, you can edit this line.
- We created a config file to use in nginx container and bind It as a volume `./default.conf:/etc/nginx/conf.d/default.conf`.
