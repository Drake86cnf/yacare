#!/bin/sh
rm -rf docs/class/*
php bin/phpdoc -d src -t docs/class

