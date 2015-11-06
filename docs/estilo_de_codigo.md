# Convenciones de estilo para el código

## Nombres de variables y funciones

Las variables y los nombres de clases, métodos y miembros definidos por el programador se escriben en PascalCase
(CamelCase con la primera letra mayuscula). La excepción son las variables de nombres muy cortos, normalmente de corta
vida y con un sentido muy obvio (por ejemplo la variable $i en un bucle sencillo).

```php
class Persona {
    public $Nombre;
    public $DomicilioReal;
    
    public function ProcesarPendientes() {
        for($i = 0; $i < $this->CantidadPendientes; $i++) {
            // ...
        }
    }
}
```

### Parámetros

Los parámetros de los métodos y funciones se escriben en camelCase tradicional (con la primera letra minúscula).

```php
public function ObtenerSaldo($numeroCuenta, $cliente) {
}
```

### Twig

Las variables de Twig se escriben en minúsculas y usando guión bajo para separar palabras.

## SQL y DQL

En consultas SQL o DQL, las palabras clave de SQL o DQL se escriben en mayúsculas. Los nombres de tablas o entidades se
escriben respetando las mayúsculas y las minúsculas del nombre original. Los alias de tablas y campos se escriben con
minúsculas y normalmente con nombres cortos de una o dos letras.

```sql
SELECT * FROM Personas p WHERE p.Edad > 18;
```

## Otras convenciones

Para todo aquello que no se especifique claramente en este documento, se asumen las recomendaciones de Symfony
(http://symfony.com/doc/current/contributing/code/standards.html), que a su vez adopta las recomendaciones PSR-1, PSR-2
y PSR-4 y de Twig (http://twig.sensiolabs.org/doc/coding_standards.html).
