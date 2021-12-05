Per eseguire il progetto:

1) Configurare il file .env e poi 
2) Entrare nella dir del progetto ed eseguire
    - composer install
    - php artisan key:generate
    - php artisan config:cache
    - php artisan migrate
    - php artisan db:seed

3) Avviare il server con il comando 
    php artisan serve
