
# Simple Marketplace API

Basic API for a marketplace platform, focusing on product listings and user authentication.



## Instalation

Clone this project to your local

```bash
  git clone https://github.com/Raihanki/simple_marketplace_api.git
```

rename .env.example to .env

```bash
  cp .env.example .env
```

install all dependencies that needed
```bash
  composer install
```

generate application key
```bash
  php artisan key:generate
```

update database information

- open .env file change this following code to your database information. By default it will connect to simple_marketplace_api database with username root and no password.
```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=simple_marketplace_api
  DB_USERNAME=root
  DB_PASSWORD=
```

run migration and seeder
```bash
  php artisan migrate --seed
```

run server
```bash
  php artisan serve
```


## API Documentation

For api documentation you can download postman and import than copy the postman collection API down below

https://api.postman.com/collections/7777643-cb401f76-0504-4566-be70-fdaf18dd80b2?access_key=PMAT-01HGYWMG41N24CFKJ185CXWC5H

response status code:

200: ok

201: created

422: uprocessable entity (validation error)

401: unauthenticated

403: access forbidden

404: not found

500: server error


