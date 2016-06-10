git clone https://github.com/brnbp/brnpod.git .

composer install

mv .env.example .env

php artisan key:generate

php artisan serve
