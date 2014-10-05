default:
	@echo "Usage: make <command>"
	@echo ""
	@echo "Available commands:"
	@echo "  COMPOSER:"
	@echo "    composer_selfupdate    Updates composer binary"
	@echo "    composer_update        Install composer dependencies"
	@echo "    composer_autoload      Regenerate autoloader"
	@echo ""
	@echo "  DATABASE:"
	@echo "    database_create        Creates database from entities annotations"
	@echo "    database_update        Updates database from entities annotations"
	@echo ""
	@echo "  TOOLS:"
	@echo "    phpunit                Run PHP unit tests with PHPUnit and create code coverage HTML reports"
	@echo "    phpcs                  Check PHP code styles with code sniffer (PSR-2)"
	@echo ""
	@echo "  FRONT-END:"
	@echo "    compass                Compiles SASS files with compass"

composer_selfupdate:
	composer self-update

composer_update: composer_selfupdate
	composer update;

composer_autoload:
	composer dump-autoload

database_create:
	php public/index.php orm:schema-tool:create

database_update:
	php public/index.php orm:schema-tool:update

phpunit: composer_update
	./vendor/bin/phpunit -c module/RSS/tests/phpunit.xml --coverage-html data/docs/rss-coverage

phpcs: composer_update
	./vendor/bin/phpcs --standard=PSR2 --ignore=*.phtml --ignore=tests/bootstrap.php ./module ./config

compass:
	compass compile -s compressed --no-line-comments --sass-dir="public/sass" --css-dir="public/css"