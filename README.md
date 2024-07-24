## Description

This is not a complex online marketplace implemented on DDD structure. The domains layer is located in the src folder

### Installation

### Docker (if u dont have installed locally php and node - u should add these containers in docker-compose)

```
docker-compose up --build -d
```

### Install dependencies

```
 composer install
 npm install
```

### Make storageLink, make migrations,

```
php artisan app:install
```

### Make .env and env.testing from env.example

### Also for development im using telescope (offical packages) and laraveldebugbar which u can find:

```
  github.com/barryvdh/laravel-debugbar
```
