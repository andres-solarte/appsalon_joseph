# Pruebas Unitarias

Este proyecto incluye pruebas unitarias usando PHPUnit para validar la funcionalidad de los modelos y clases principales.

## Instalación

Las dependencias de desarrollo (incluyendo PHPUnit) se instalan automáticamente cuando ejecutas:

```bash
composer install
```

O específicamente para desarrollo:

```bash
composer install --dev
```

## Ejecutar Pruebas

### Localmente (sin Docker)

```bash
./vendor/bin/phpunit
```

O con configuración específica:

```bash
./vendor/bin/phpunit --configuration phpunit.xml
```

### Con Docker

```bash
# Instalar dependencias de desarrollo
docker compose run --rm appsalon composer install

# Ejecutar pruebas
docker compose run --rm appsalon ./vendor/bin/phpunit --configuration phpunit.xml
```

### Ejecutar pruebas específicas

```bash
# Ejecutar solo pruebas de Usuario
./vendor/bin/phpunit tests/Unit/UsuarioTest.php

# Ejecutar solo pruebas de Servicio
./vendor/bin/phpunit tests/Unit/ServicioTest.php
```

## Estructura de Pruebas

- `tests/Unit/UsuarioTest.php` - Pruebas para el modelo Usuario (validaciones, hash de password, tokens)
- `tests/Unit/ServicioTest.php` - Pruebas para el modelo Servicio (validaciones)
- `tests/Unit/EmailTest.php` - Pruebas para la clase Email (construcción)

## Notas

- Las pruebas actuales se enfocan en la lógica de validación y métodos que no requieren conexión a base de datos
- Para pruebas que requieren base de datos, se recomienda usar mocks o una base de datos de prueba
- Las pruebas se ejecutan automáticamente en el pipeline de CI/CD (Jenkins)

