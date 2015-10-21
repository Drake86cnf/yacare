# Instalación de Yacaré para desarrollo

Estas instrucciones son sólo para programadores o desarrolladores que estén interesados
en contribuir o modificar el código fuente de Yacaré.

El código fuente está disponible en GitHub y se puede descargar de forma pública y anónima.

https://github.com/municipioriogrande/yacare

## En Linux

El entorno recomendado para desarrollo es Linux. Cualquier distribución sirve, pero se
prefiere una distribución con buen soporte para herramientas de desarrollo y especialmente
para el entorno Eclipse PDT, como Fedora.

Es necesario instalar los siguientes paquetes:

* PHP 5.5 o superior
* MariaDB 10.0 o superior (también se puede usar MySQL).
* Un cliente Git.
* Un editor de textos o entorno de desarrollo, se recomienda Eclipse PDT con:
	* Plugin para Symfony (http://symfony.dubture.com)
	* Plugin de PlantUML (http://es.plantuml.com/eclipse.html)
	* Plugin de EGit (http://www.eclipse.org/egit/download/)
	* Plugin de para preview de Markdown de GitHub (https://marketplace.eclipse.org/content/github-flavored-markdown-viewer-plugin-eclipse)

### Instalar prerequisitos

#### En Fedora

```shell
dnf install git php-pear-Image-GraphViz graphviz-php \
	php-cli php-gd php-mysqlnd php-intl php-ldap \
	php-apcu php-xdebug php-mbstring composer plantuml
```

Y para instalar el entorno de desarrollo Eclipse:

```shell
dnf install eclipse-pdt eclipse-mpc
```

Y es necesario instalar un servidor MariaDB o MySQL si no se tiene uno:

```shell
dnf install mariadb-server
```

#### En Ubuntu

```shell
apt-get install git php5 php5-cli php5-gd php5-mysqlnd \
	php5-intl php5-ldap php5-apcu php5-xsl php5-xdebug
```

En Ubuntu y probablemente en otras distribuciones deberá descargar Eclipse PDT
según las instrucciones de la página (https://eclipse.org/pdt/).      

Además, es necesario instalar un servidor MariaDB o MySQL si no se tiene uno.

### Descargar el código fuente e iniciar la carpeta de desarrollo

Abrir una consola de comandos para los siguientes pasos:

```shell
git clone https://github.com/municipioriogrande/yacare.git
cd yacare
```

Descargar Composer (no es necesario en Fedora)

```shell
php -r "readfile('https://getcomposer.org/installer');" | php
sudo mv composer.phar /usr/local/bin/composer
```

Crear el proyecto (para descargar vendors)

```shell
composer create-project
```

Crear la base de datos y el usuario de acceso

```shell
mysql -uroot -p
```
```sql
CREATE DATABASE yacadev;
GRANT ALL ON yacadev.* TO 'yacadev'@'localhost' IDENTIFIED BY '123456';
GRANT ALL ON yacadev.* TO 'yacadev'@'%' IDENTIFIED BY '123456';
CREATE DATABASE yacatest;
GRANT ALL ON yacatest.* TO 'yacatest'@'localhost' IDENTIFIED BY '123456';
GRANT ALL ON yacatest.* TO 'yacatest'@'%' IDENTIFIED BY '123456';
EXIT;
```

Si se dispone de datos de prueba, se los puede incorporar

```shell
mysql -uyacadev -p123456 --database=yacadev < yacadev.sql
```

Instalar los assets

```shell
php bin/console assets:install
php bin/console assetic:dump
```

Actualizar las estructuras de datos

```shell
php bin/console doctrine:schema:update --force
```

Ejecutar el servidor web de desarrollo

```shell
php bin/console server:start
```

Ahora puede abrir en un navegador la dirección del servidor local: http://localhost:8000/app_dev.php/ 

Correr el conjunto de pruebas y generar documentación sobre cobertura:

```shell
bin/phpunit -v --coverage-html docs/cov
```

Generar documentación sobre la API:

```shell
bin/phpdoc -d src -t docs/class
```

## En Windows

* Descargar e instalar su distribución favorita de Linux, por ejemplo Fedora (https://getfedora.org/es/workstation/download/).
* Continuar desde el paso 1 de la sección anterior.
