.PHONY: dev
dev:
    docker-compose up- d

.PHONY: down
down:
    docker-compose down

.PHONY: phpcs
phpcs:
    vendor/bin/phpcs

.PHONY: phpstan
phpstan:
    vendor/bin/phpstan