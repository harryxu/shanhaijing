test:
	mysql -uroot -e 'CREATE DATABASE IF NOT EXISTS `shj_test` COLLATE `utf8_general_ci`;'
	./artisan migrate --env=testing
	./artisan db:seed --env=testing
	phpunit
	mysql -uroot -e 'DROP DATABASE `shj_test`;'
