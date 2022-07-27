# Trabajo de Fin de Grado: Herramienta de gestión de negocios de cita previa y venta de productos

## BusinessApp - Web Service

### Autor: Antonio Jiménez Rodríguez
### Tutor: Javier Martínez Baena
___

La documentación de este proyecto está realizada con `LaTeX`, por lo
tanto para generar el archivo PDF necesitaremos instalar `TeXLive` en
nuestra distribución.

Una vez instalada, tan solo deberemos situarnos en el directorio `doc` y ejecutar:

    make

---

### Instalación
Para la inicialización de la aplicación **Symfony** lanzaremos los siguientes comandos:

```shell
# Instalación del cliente de Symfony
wget https://get.symfony.com/cli/installer -O - | bash
# Inicialización de la aplicación
symfony new BusinessAppWS 
```
Se deberán añadir los nuevos archivos generados al _stage_ de _git_ y commitearlos para el seguimiento.

---

### Actualizaciones en Base de Datos
Para aplicar cambios realizados en la estructura de la base de datos se deberán ejecutar los siguientes comandos:

```shell
# Generación de un nuevo archivo migration con los cambios
php bin/console doctrine:migrations:diff
# Ejecución del migration
php bin/console doctrine:migrations:execute --up DoctrineMigrations\VersionXXXXXXXXXX
```

En caso de querer revertir los cambios:

```shell
php bin/console doctrine:migrations:execute --down DoctrineMigrations\VersionXXXXXXXXXX
```

---

### Generación de claves SSL

Para la generación de claves SSL para la autenticación con JWT utilizaremos:

```shell
php bin/console lexik:jwt:generate-keypair
```

---

### Contenedores Docker

Se ha dockerizado la aplicación para facilitar el despliegue de la misma en otros servidores.

Algunos de los comandos a destacar son:

```shell
# Levantar el contenedor en segundo plano reconstruyendo las imágenes
docker-compose up -d --build

# En la APP de Symfony dentro del contenedor de PHP
docker-compose exec php-service bin/console cache:clear
docker-compose exec php-service bin/console doctrine:migrations:diff
docker-compose exec php-service bin/console doctrine:migrations:execute --up DoctrineMigrations\VersionXXXXXXXXXXXXXX
docker-compose exec php-service composer require _packagename_

# Para abrir el bash de cualquier de los diferentes servicios levantados
docker-compose exec -it php-container-ws bash
docker-compose exec mysql-container-ws bash
docker-compose exec nginx-container-ws bash

# Acceder a la base de datos desde el bash de MYSQL
mysql -uroot -psecret

```

---

### EasyAdminBundle

Se ha hecho uso del bundle EasyAdminBundle para la creación de la administración del Back-End del sistema.

Algunos de los comandos a destacar son:

```shell
# Creación del Dashboard principal
php bin/console make:admin:dashboard

# Creación de CRUD de entidades
php bin/console make:admin:crud

```

---


