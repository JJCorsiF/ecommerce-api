mysql -u root -e "CREATE DATABASE IF NOT EXISTS vipcommerce;"
mysql -u root -e "CREATE DATABASE IF NOT EXISTS vipcommerce_testing;"
mysql -u root -e "CREATE USER IF NOT EXISTS 'vipcommerce'@'localhost' IDENTIFIED BY 'vipcommerce';"
mysql -u root -e "GRANT ALL PRIVILEGES ON vipcommerce.* TO 'vipcommerce'@'localhost';"
mysql -u root -e "GRANT ALL PRIVILEGES ON vipcommerce_testing.* TO 'vipcommerce'@'localhost';"
mysql -u root -e "FLUSH PRIVILEGES;"
mysql -u root -e "USE vipcommerce;"
cp .env.testing .env
sed -i "s|APP_URL=.*|APP_URL=${GITPOD_WORKSPACE_URL}|g" .env
sed -i "s|APP_URL=https://|APP_URL=https://8000-|g" .env
sed -i "s|DB_DATABASE=.*|DB_DATABASE=vipcommerce|g" .env
sed -i "s|DB_DATABASE=.*|DB_DATABASE=vipcommerce_testing|g" .env.testing
composer install
php artisan key:generate
