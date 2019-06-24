
### SERVER-RUN ###
.PHONY: server
server:
	 docker run --rm -it -v $$PWD:/app -w /app --expose 8080 php:7.3-cli bin/console server:run 0.0.0.0:8080

### COMPOSER-INSTALL ###
.PHONY: composer
composer:
	 docker run --rm -it -v $$PWD:/app -w /app -u $$(id -u):$$(id -g) composer require simple-bus/symfony-bridge

### UNIT-TEST ###
.PHONY: tests
tests:
	docker run --rm -it -v $$PWD:/app -w /app php:7.3-cli vendor/bin/phpunit tests