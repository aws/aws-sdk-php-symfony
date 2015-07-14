test:
	vendor/bin/phpunit

phpfmt:
	vendor/bin/phpcbf --standard=PSR2 src/ tests/ build/ \
	--ignore=tests/fixtures/cache/
