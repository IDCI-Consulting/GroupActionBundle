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


# NodeJs commands

.PHONY: npm-install
npm-install:
	docker-compose run --rm node npm install $(options)

.PHONY: yarn
yarn:
	docker-compose run --rm node yarn $(cmd) $(options)

.PHONY: webpack-dev
webpack-dev:
	docker-compose run --rm node yarn run webpack-dev

.PHONY: webpack-prod
webpack-prod:
	docker-compose run --rm node yarn run webpack-prod

.PHONY: sass-dev
sass-dev:
	docker-compose run --rm node yarn run sass-dev $(options)

.PHONY: sass-prod
sass-prod:
	docker-compose run --rm node yarn run sass-prod $(options)


# PHP commands

.PHONY: composer-add-github-token
composer-add-github-token:
	docker-compose run --rm php composer config --global github-oauth.github.com $(token)

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


# Symfony2.x app commands

.PHONY: pac
pac:
	docker-compose run --rm php php app/console $(cmd)

.PHONY: phpunit
phpunit: ./vendor/phpunit/phpunit/phpunit ./phpunit.xml.dist
	docker-compose run --rm php php ./vendor/phpunit/phpunit/phpunit

default: pac
