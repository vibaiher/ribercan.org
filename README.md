ribercan.org
============

[![Build Status](https://travis-ci.org/vibaiher/ribercan.org.svg)](https://travis-ci.org/vibaiher/ribercan.org)
[![Code Climate](https://codeclimate.com/github/vibaiher/ribercan.org/badges/gpa.svg)](https://codeclimate.com/github/vibaiher/ribercan.org)
[![Test Coverage](https://codeclimate.com/github/vibaiher/ribercan.org/badges/coverage.svg)](https://codeclimate.com/github/vibaiher/ribercan.org/coverage)

The new website of [Ribercan - Sociedad Protectora de Animales de La Ribera](http://www.ribercan.org).

### Installation

- Install docker and docker-compose
- Run `docker-compose up --build -d`
- Run `docker-compose run --rm ribercan php bin/console doctrine:database:create --env=dev`
- Run `docker-compose run --rm ribercan php bin/console doctrine:schema:update --force --env=dev`
- Go to `http://localhost:8000`
- Enjoy :P

### Testing

#### Prepare database

- `docker-compose build`
- `docker-compose run --rm ribercan php bin/console doctrine:database:create --env=test`
- `docker-compose run --rm ribercan php bin/console doctrine:schema:create --env=test`

#### Execute suite test

- `docker-compose run --rb ribercan php vendor/bin/phpunit`
