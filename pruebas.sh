#!/bin/sh
php app/console doctrine:schema:update --env=test --force
phpunit -c app --coverage-html ./cov
