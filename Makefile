test: clean-tests
	vendor/bin/phpunit

clean-tests:
	rm -rf tests/fixtures/cache/*

phpfmt:
	vendor/bin/phpcbf --standard=PSR2 src/ tests/ build/ \
	--ignore=tests/fixtures/cache/
