#!/bin/sh
php bin/console assetic:dump
php bin/console assets:install
#--symlink --relative
php bin/console server:start
