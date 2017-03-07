up:
	docker-compose up --build -d

build:
	docker-compose build

test:
	docker-compose run --rm ribercan php vendor/bin/phpunit
