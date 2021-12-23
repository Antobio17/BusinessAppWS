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