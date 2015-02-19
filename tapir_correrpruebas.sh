#!/bin/sh
php bin/console doctrine:schema:update --env=test --force --dump-sql
php bin/phpunit

