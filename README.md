# Sistem Informasi Permintaan Makanan Pasien Rawat Inap RSKM PEC

## Prerequisites

- Install and run Docker Desktop
  - [https://www.docker.com/get-started ](https://www.docker.com/get-started)

## Run Docker images

On the command line (the terminal)

- Clone this repository where you want it.
  - `git clone https://github.com/hafizulwanandaputra/pec_permintaanmakanan_docker`
- Change into the directory
- `cd pec_permintaanmakanan_docker`
- Change the MySQL account info in the `docker-compose.yml` file if you want

```
  MYSQL_ROOT_PASSWORD: "12345"
  MYSQL_DATABASE: "pec_permintaanmakanan"
```

- Create a new docker network
  - `docker network create traefikNetwork`
- Start the container
  - `docker compose up`
  - Or run it in the background to free up the terminal
    - `docker compose up -d`
- To stop the containers
  - press ctrl-c
  - then run `docker compose down`
- View the web pages at [http://localhost/html/ ](http://localhost/html)
  - type the username `admin` and password `12345`. Password can be changed in [http://localhost/html/settings/changepassword ](http://localhost/html/settings/changepassword).
- View phpMyAdmin at [http://pma.localhost ](http://pma.localhost)
  - type in the db user name and db password to log in

## General Notes

- This will run four containers: a proxy container, a PHP-Apache container, a MySQL container and
  a phpMyAdmin container.
- All of the files for the website building can go in the `www` folder.
- The database files are stored in the `dbdata` folder. This allows for the
  data to persist between restarts and for hands on access.
  - To restart with a clean database, just delete this folder.
  - To seed the database with a database, tables, and data, just uncomment the
    line in the docker-compose.yml file referencing `pec_permintaanmakanan_nodb.sql`. The `dbdata`
    folder will need to be deleted first. This works best if using a mysql dump
    file. Otherwise, the sql file just needs to have valid SQL statments.
    - `#- ./pec_permintaanmakanan_nodb.sql:/docker-entrypoint-initdb.d/pec_permintaanmakanan_nodb.sql`

## Traefik Notes

This uses the Traefik image from here: https://hub.docker.com/_/traefik/

- Documentation is here: https://doc.traefik.io/traefik/
- You can have multiple domains and subdomains pointing to a single container
  using the Hosts line in the label section of docker-compose.yml - `` "traefik.http.routers.php-apache.rule=Host(`localhost`)" ``

## PHP Settings

By default the file upload size and post limit size are set to 256MB. If you
need to change these values, edit the `uploads.ini` file.
