Project Installation
1.composer install or composer install --ignore-platform-reqs
2.composer dump-autoload
3.Run cp .env.example .env
4.Run php artisan key:generate
5.Run php artisan migrate
6.Run php artisan serve
7.Go to link localhost:8000
---

Run Data example
1.php artisan db:seed --class=InitialSeeder
2.php artisan db:seed --class=WarehouseSeeder
3.php artisan db:seed --class=UserSeeder
