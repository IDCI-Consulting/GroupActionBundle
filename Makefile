# Variables

php_sources         ?= .
phpcs_ignored_files ?= vendor/*,app/cache/*


# Bash Commands

.PHONY: command
command:
	docker-compose run --rm php $(cmd)

.PHONY: bash
bash:
	docker-compose exec php bash


# Docker commands

.PHONY: build-image
build-image:
	docker build -t idci-group-action/php:7.2-fpm -f .docker/php/Dockerfile .

.PHONY: up
up:
	docker-compose up -d

.PHONY: down
down:
	docker-compose down


# NPM commands

.PHONY: npm-install
npm-install:
	docker run --rm -i -v `pwd`:/usr/src/app -w /usr/src/app node:9.5.0 npm install $(options)

.PHONY: webpack-dev
webpack-dev:
	docker run --rm -i -v `pwd`:/usr/src/app -w /usr/src/app node:9.5.0 npm run webpack-dev

.PHONY: webpack-prod
webpack-prod:
	docker run --rm -i -v `pwd`:/usr/src/app -w /usr/src/app node:9.5.0 npm run webpack-prod


# PHP commands
.PHONY: composer-update
composer-update:
	docker-compose run --rm php composer update $(options)

.PHONY: composer-install
composer-install:
	docker-compose run --rm php composer install $(options)

.PHONY: phploc
phploc:
	docker run -i -v `pwd`:/project jolicode/phaudit bash -c "phploc $(php_sources); exit $$?"

.PHONY: phpcs
phpcs:
	docker run -i -v `pwd`:/project jolicode/phaudit bash -c "phpcs $(php_sources) --extensions=php --ignore=$(phpcs_ignored_files) --standard=PSR2; exit $$?"

.PHONY: phpcpd
phpcpd:
	docker run -i -v `pwd`:/project jolicode/phaudit bash -c "phpcpd $(php_sources); exit $$?"

.PHONY: phpdcd
phpdcd:
	docker run -i -v `pwd`:/project jolicode/phaudit bash -c "phpdcd $(php_sources); exit $$?"

.PHONY: phpcs-fix
phpcs-fix:
	docker run --rm -i -v `pwd`:`pwd` -w `pwd` grachev/php-cs-fixer --rules=@Symfony --verbose fix $(php_sources)