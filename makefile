.PHONY: default

# variables
APP_NAME=trotz_web

# Tasks
default: run-docker-up

run-docker-up:
	@npm install && \
	docker-compose up -d && \
	docker-compose exec -T app-trotz bash -c "composer update && \
	php artisan migrate && \
	php artisan key:generate && \
	php artisan db:seed"


