
--------------
DB - sql.lite.
Tables and entities are already created. 
#docker-compose up -d
#docker-compose exec php composer install 
#docker-compose exec php php bin/console doctrine:schema:create
To populate db with fixtures run: php bin/console doctrine:fixtures:load
#docker-compose exec php php bin/console doctrine:fixtures:load
