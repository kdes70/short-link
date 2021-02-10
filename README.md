# short-link
test application


### Frontend
cd frontend folder

copy ``.env.example`` file named ``.env.local``

run ``npm i``

run ``npm run build``

### Backend

cd backend folder

copy ``.env.example`` file named ``.env``

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

cd root folder

run 
```docker-compose up -d```

run ```docker exec -it short_link_php bash```

run _$ ```composer install```

run _$ ```php artisan migrate```

run _$ ```php artisan key:generate```

run _$ ```php artisan jwt:secret```

## Done !
