.PHONY: dev
dev: vendor/autoload.php
    docker-compose up -d

.PHONY: down
down: vendor/autoload.php
    docker-compose down

.PHONY: phpcs
phpcs: vendor/autoload.php
    vendor/bin/phpcs

.PHONY: phpcbf
phpcs: vendor/autoload.php
    vendor/bin/phpcbf

.PHONY: phpstan
phpstan: vendor/autoload.php
    vendor/bin/phpstan

.PHONY: migration
migration: vendor/autoload.php
	docker-compose exec php bin/console make:migration

.PHONY: migrate
migrate: vendor/autoload.php
	docker-compose exec php bin/console doctrine:migrations:migrate

vendor/autoload.php: composer.lock
	composer install
	touch vendor/autoload.php