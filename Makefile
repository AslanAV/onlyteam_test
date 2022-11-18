start:
	php -S localhost:3000 src/public/index.php

heroku-log:
	heroku logs --tail

deploy:
	git push heroku main

setup:
	composer install

