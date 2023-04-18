install: #Запуск composer install
	composer install
validate: #Запуск composer install
	composer validate
lint: #Запуск Линтера
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests
gendiff:
	bin/gendiff file/file11.json file/file22.json
test:
	composer exec --verbose phpunit tests
test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
