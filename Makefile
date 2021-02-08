docker-up: memory
	docker-compose up -d

docker-down:
	docker-compose down

docker-build: memory
	docker-compose up --build -d

test:
	docker-compose exec -u www-data app vendor/bin/phpunit