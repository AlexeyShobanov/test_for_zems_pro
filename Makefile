setup:
	composer install
	cp -n .env.example .env
	php artisan key:gen --ansi
	touch database/database.sqlite || true
	php artisan migrate
	php artisan db:seed --force

serve:
	php artisan serve --host test.lcl

migrate:
	php artisan migrate

console:
	php artisan tinker

db:
	docker-compose up

test:
	php artisan config:clear
	php artisan test

lint:
	composer phpcs -- --standard=PSR12 app routes tests

logs:
	tail -f storage/logs/laravel.log

clear:
	php artisan route:clear
	php artisan cache:clear
	php artisan view:clear
	php artisan config:clear
	composer dump-autoload