SACEP
===

Sistema Automatizado para control de evaluaciones y personal de [Mukumbarí Sistema Teleférico de Mérida](http://mukumbari.com)

Actualmente esta en desarrollo :construction:

![sacep-evaluacion](https://user-images.githubusercontent.com/6052183/29584972-73e3d26c-8753-11e7-8804-d3a72bcf56f2.png)

Desarrollo
--
:construction_worker: Desarrollador: **Jesús Vielma**

:eyes: Recolección de datos: **Joeinny Osorio**

El sistema de desarollado bajo el framework Laravel 5.4 utilizando plantillas basadas en bootstrap

### Requisitos de instalación
- Composer
- PHP > 5.6
- Apache2
- MySQL

#### Instalación
1. Clone este repositorio o [descarguelo](https://github.com/StydeNet/html/archive/master.zip) dentro de su carpeta de apache `/var/www/`
2. Utilizar composer para instalar todas las dependencias
	1. `cd /var/www/sacep`
	2. `composer install`
3. Cambiar los permisos a:
	1. `sudo chmod 755 -R /var/www/sacep`
	2. `sudo chmod 777 -R /var/www/sacep/storage`
4. Cambiar el dueño de la carpeta storage
      1. `sudo chown www.data:www.data -R /var/www/sacep/storage`
5. Realizar una copia del archivo `.env.example` (que esta en el root de sacep) y configurar los aspectos de la base de datos, el nombre del archivo debe quedar como .env
6. Dentro de la carpeta sacep ejecutar el siguiente comando
	1. php artisan key:generate
7. Crear el virtual host de apache para que escuche a un puerto diferente
	1. `sudo nano /etc/apache2/sites-available/sacep.conf`
    2. Ejemplo:
	```apache
	<VirtualHost *:801>
			ServerName sacep.app
			DocumentRoot /var/www/sacep/public

			<Directory />
				Options FollowSymLinks
				AllowOverride None
			</Directory>
			<Directory /var/www/sacep>
				AllowOverride All
				</Directory>
	</VirtualHost>
	```

8. Configurar apache para que escuche el puerto descrito en l `VirtualHost`
9. Si se esta en Debian o derivados habilitar el sitio y reiniciar apache
10. Ya puedes acceder en tu navegar a la dirección ip del mismo incluyendo el puerto.
11. Si solo se esta probando el sistema se utilizar el comando `php artisan migrate --seed` (este comando genera data de pruebas). Si se utilizara el sistema en produccion, `php artisan migrare && php artisan db:seed --class=SeederTablaUsuario`
12. Una vez echo esto puede acceder al sistema con el correo _admin@sacep.app_ clave _admin_
