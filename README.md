# AppSalon (PHP MVC + MySQL)

Aplicación de ejemplo para agendamiento de citas construida en PHP con un mini MVC propio, vistas en PHP, Active Record simple, y build de assets con Gulp/Sass. Se incluyen definiciones de Docker para ejecutar todo el stack (Apache + PHP, MySQL y phpMyAdmin) con un solo comando.

## Stack
- PHP 8.2 + Apache (DocumentRoot en `public/`)
- MySQL 8.0 (con seed automático)
- phpMyAdmin (UI para DB)
- Node/Gulp para compilar assets (ejecutado en build multi-stage del Dockerfile)

## Estructura relevante
- `Dockerfile`: imagen de la app (construye assets y corre Apache+PHP)
- `compose.yml`: orquesta app, MySQL y phpMyAdmin
- `appsalon_joseph.sql`: seed de base de datos (importado automáticamente al primer arranque)
- `public/`: webroot

## Requisitos
- Docker y Docker Compose

## Variables de entorno
Crea un archivo `.env` en `appsalon_joseph/` con al menos estas variables para MySQL:

```env
MYSQL_DATABASE=appsalon_joseph
MYSQL_USER=app
MYSQL_PASSWORD=app
MYSQL_ROOT_PASSWORD=root
```

La aplicación leerá internamente:
- `DB_HOST=db`
- `DB_PORT=3306`
- `DB_NAME=${MYSQL_DATABASE}`
- `DB_USER=${MYSQL_USER}`
- `DB_PASS=${MYSQL_PASSWORD}`

Estas referencias ya están cableadas en `compose.yml`.

## Cómo ejecutar
Desde la carpeta raíz del repositorio o directamente dentro de `appsalon_joseph/`:

```bash
# Recomendado: ejecuta en la carpeta appsalon_joseph/
cd appsalon_joseph

# Levantar todo (con build de imagen)
docker compose up --build
```

- App: `http://localhost:8080`
- phpMyAdmin: `http://localhost:8081` (Host: `db`, Usuario/Password: `${MYSQL_USER}`/`${MYSQL_PASSWORD}`)

La primera vez, MySQL importará automáticamente `appsalon_joseph.sql`.

## Comandos útiles
```bash
# Detener contenedores (mantiene datos de MySQL)
docker compose down

# Detener y borrar volúmenes (resetea la base de datos)
docker compose down -v

# Reconstruir imagen si cambias Dockerfile o dependencias
docker compose build --no-cache
```

## Notas
- El Dockerfile usa multi-stage: compila `public/build/` con Node/Gulp en una etapa de build y sólo copia los artefactos a la imagen final.
- `mod_rewrite` está habilitado y `DocumentRoot` apunta a `public/`.
- La app requiere las variables de base de datos (ya inyectadas por `compose.yml`). Si cambias credenciales en `.env`, no olvides recrear los servicios.


