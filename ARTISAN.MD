Step
1.composer install --ignore-platform-reqs
2.composer dump-autoload
3.php artisan db:seed --class=InitialSeeder 
4.php artisan db:seed --class=WarehouseSeeder
5.php artisan db:seed --class=UserSeeder
