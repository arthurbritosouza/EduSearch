name_container="$1" 
echo "Executando dockerLaravel para $name_container"
cd "$(pwd)"
echo "Entrando no diretório $(pwd)"
sudo docker-compose up -d
sudo docker exec "$name_container" chown -R www-data:www-data /var/www/html/storage
sudo docker exec "$name_container" chown -R www-data:www-data /var/www/html/bootstrap

sleep 15

composer install
npm install
php artisan key:generate 

echo "Limpando caches"
sudo docker exec "$name_container" php artisan cache:clear
sudo docker exec "$name_container" php artisan config:clear
sudo docker exec "$name_container" php artisan route:clear
sudo docker exec "$name_container" php artisan view:clear
sudo docker exec "$name_container" php artisan config:cache
sudo docker exec "$name_container" php artisan route:cache
sudo docker exec "$name_container" php artisan event:cache
sudo docker exec "$name_container" php artisan optimize:clear
echo "Executando migrações"

sudo docker exec "$name_container" php artisan migrate