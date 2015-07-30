#!/bin/sh
php bin/console server:stop
sleep 3
php bin/console assetic:dump
php bin/console assets:install
#--symlink --relative
php bin/console server:start
