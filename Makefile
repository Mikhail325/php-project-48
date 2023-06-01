install:
	composer install
validate:
	composer validate
lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests
gendiff:
	bin/gendiff $(file1) $(file2) 
test:
	composer exec --verbose phpunit tests
test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml
