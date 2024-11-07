.PHONY: default

# variables
APP_NAME=trotz_web

# Tasks
default: run-docker-up

run-docker-up:
	@docker-compose up -d && \
	docker-compose exec -T app-trotz bash -c "composer update && \
	npm install && \
	npm run build && \
	php artisan migrate && \
	php artisan key:generate && \
	php artisan storage:link && \
	php artisan db:seed"


