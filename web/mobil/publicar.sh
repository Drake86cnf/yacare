#!/bin/sh
rm actualizar.zip
zip -r actualizar.zip * --exclude \*.sqlite debug\*

