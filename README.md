# Application to saving favorite sites.

![demo-image](image.png)

## Start application

1. Setting up the environment.

```
./vendor/bin/sail up 
```

To run in the background.

```
./vendor/bin/sail up -d
```

2. Preparing the database by execute migrations.


```
./vendor/bin/sail php artisan migrate 
```

3. Preparing the database by execute seeds.


```
./vendor/bin/sail php artisan db:seed 
```

4. Command for testing API endpoints. 

```
./vendor/bin/sail php artisan test
```

Collection API endpoints for Postman in file [testWork_47591.postman_collection.json](testWork_47591.postman_collection.json) 
