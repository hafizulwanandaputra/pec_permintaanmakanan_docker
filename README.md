# Sistem Informasi Permintaan Makanan Pasien Rawat Inap RSKM PEC

Based on [_PMAMP - PhpMyadmin with Apache Mysql and Php_ by ammonshepherd](https://github.com/ammonshepherd/pmamp)

## Prerequisites

- Install and run Docker Desktop
  - [https://www.docker.com/get-started ](https://www.docker.com/get-started)

## Run Docker images

On the command line (the terminal)

- Clone this repository where you want it.
  - `git clone https://github.com/hafizulwanandaputra/pec_permintaanmakanan_docker`
- Change into the directory
  - `cd pec_permintaanmakanan_docker`
- Start the container
  - `docker compose up`
  - Or run it in the background to free up the terminal using `docker compose up -d`
- Install composer and copy `.env` file
  - Run `docker exec -it pec_permintaanmakanan_docker-php-apache-1 /bin/bash`
  - Run `cd ..`
  - Run `cd system`
  - Run `composer install`
  - Run `cp .env.example .env`
  - Run `exit`
- To stop the containers
  - press <kbd>ctrl</kbd> + <kbd>C</kbd>
  - then run `docker compose down`
- View the web pages at [http://localhost:8088/html/ ](http://localhost:8088/html)
  - Type the username `admin` and password `12345`
  - Password can be changed in [http://localhost:8088/html/settings/changepassword ](http://localhost:8088/html/settings/changepassword)
- View phpMyAdmin at [http://pma.localhost:8088 ](http://pma.localhost:8088)
  - Type in the db user name `root` and db password to log in `12345`
  - You can change the password of MySQL database in the `docker-compose.yml` file.
    ```
      MYSQL_ROOT_PASSWORD: "12345"
    ```
    and in the `www/system/.env` file.
    ```
      database.default.password = 12345
    ```

### Saved Docker Image

[Download the image here](https://drive.google.com/file/d/1BwqKhAvlpO6a1iYQwWfgP0hWfY-MlMYS/view?usp=sharing), save it to this repository's directory, and run `docker load -i pec_permintaanmakanan_docker-php-apache.tar` to load the image. Use this if you have a trouble to build an image due to blocked connections when executing `apt update`.

## General Notes

- This will run four containers: a proxy container, a PHP-Apache container, a MySQL container and a phpMyAdmin container.
- All of the files for the website building can go in the `www` folder.
- The database files are stored in the `dbdata` folder. This allows for the data to persist between restarts and for hands on access.
  - To restart with a clean database, just delete this folder.
  - The line in the `docker-compose.yml` file referencing `pec_permintaanmakanan_nodb.sql` is used to seed the database `pec_permintaanmakanan` with a database, tables, and data of this application. The `dbdata` folder will need to be deleted first. This works best if using a mysql dump file. Otherwise, the sql file just needs to have valid SQL statments.
    - `- "./pec_permintaanmakanan_nodb.sql:/docker-entrypoint-initdb.d/pec_permintaanmakanan_nodb.sql"`
    - `MYSQL_DATABASE: "pec_permintaanmakanan"`

## Port Settings

### Server's Port

- From `docker-compose.yml`, modify these codes:
  ```
  ports:
    - "8088:80"
    - "8089:8089"
  ```
- From `www/system/.env`, modify `app.baseURL` to include ports which has been previously set from `docker-compose.yml`
  ```
  app.baseURL = 'http://localhost:8088/'
  ```

### MySQL's Port

- From `docker-compose.yml`, modify these codes:
  - From mysql:
    ```
    environment:
      ...
      MYSQL_TCP_PORT: 3390
    ports:
      - 3390:3390
    expose:
      - 3390
    ```
  - From phpmyadmin:
    ```
    environment:
      PMA_HOST: "mysql"
      PMA_PORT: "3390"
    ```
- From `www/system/.env`, modify `database.default.hostname` to include ports which has been previously set from `docker-compose.yml`
  ```
  database.default.hostname = mysql:3390
  ```

## Traefik Notes

This uses the Traefik image from here: https://hub.docker.com/_/traefik/

- Documentation is here: https://doc.traefik.io/traefik/
- You can have multiple domains and subdomains pointing to a single container using the Hosts line in the label section of `docker-compose.yml`
  - `` - "traefik.http.routers.php-apache.rule=Host(`localhost`, `127.0.0.1`)" ``

## PHP Settings

By default the file upload size and post limit size are set to 256MB. If you
need to change these values, edit the `uploads.ini` file.
