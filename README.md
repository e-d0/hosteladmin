
--------------

# Hostel admin. 

> Symfony 3.4 prototype app for hostels and hotels. DB - sql.lite

## Build Setup

``` bash
# installing

run docker and connect to container:
```
    docker-compose build
    docker-compose up -d

``` bash
# install symfony app:
docker-compose exec php composer install 
```

``` bash
# !DB already pipuleted
# to work with sql.lite db:
#create db chema
docker-compose exec php php bin/console doctrine:schema:create
#To populate db with fixtures run:
docker-compose exec php php bin/console doctrine:fixtures:load
```


