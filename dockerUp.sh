# local name_container="$1"
name_container="$1"
echo "Executando dockerLaravel para $name_container"
cd "$(pwd)"
echo "Entrando no diretório $(pwd)"
docker-compose up -d
docker exec "$name_container" chown -R www-data:www-data /var/www/html/storage
docker exec "$name_container" chown -R www-data:www-data /var/www/html/bootstrap
composer install
npm install
php artisan key:generate 

echo "Limpando caches"
docker exec "$name_container" php artisan cache:clear
docker exec "$name_container" php artisan config:clear
docker exec "$name_container" php artisan route:clear
docker exec "$name_container" php artisan view:clear
docker exec "$name_container" php artisan config:cache
docker exec "$name_container" php artisan route:cache
docker exec "$name_container" php artisan event:cache
docker exec "$name_container" php artisan optimize:clear
docker exec apt-get update && apt-get install -y default-mysql-client
echo "Executando migrações"
sleep 15
docker exec "$name_container" php artisan migrate

