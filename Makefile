all: composer migrate npm init

composer:
	composer install

npm:
	npm install && npm run build

migrate:
	php artisan migrate --seed && php artisan migrate --database=test

init:
	php artisan app:update-rates
