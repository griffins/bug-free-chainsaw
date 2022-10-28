read -r -d '' DEPLOY <<EOF
git pull
chmod 777 -R storage/
chmod 777 bootstrap/cache
composer install --no-interaction
php artisan migrate --force --step
php artisan horizon:terminate
php artisan view:clear
php artisan book:update
php artisan match:update
rm -rf storage/logs/*.log
EOF

read -r -d '' COMMAND <<EOF
cd /var/www/app
$DEPLOY
EOF

git commit -a -m 'fix'
git push && ssh root@loopy.co.ke "$COMMAND"

