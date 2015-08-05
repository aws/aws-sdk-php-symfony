test: clean-tests
	vendor/bin/phpunit

clean-tests:
	rm -rf tests/fixtures/cache/*
