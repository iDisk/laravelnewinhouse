# Desarrollos Especiales Espacios de México

## Objetivo
Contar con un punto de partida para el inicio de proyectos de desarrollo web usando el framework de PHP Laravel 5.5, contando con un kit de inicio que permita tener funcionalidades estándar en este tipo de proyectos

## Entorno de desarrollo sugerido
Para poder usar este código se recomienda contar con lo siguiente:

* Equipo de computo 
* PHP 7.1
* Servidor de Base de datos MySQL 5.7 o superior
* Servidor Web (Puede ser apache 2.2 o NGINX)
* Sequel Pro o MySQL Workbench para manejar MySQL
* Editor de textos o IDE de su preferencia
* manejador de paquetes PHP composer
* Homestead para Laravel es una excelente opción

## Inicialización del proyecto

* descargar el proyecto de GitHub

Seguir checklist

      git clone https://danterobles@bitbucket.org/tecnologia-espacios/starterkit55.git
      
     cd starterkit55
     
     cp .env_ejemplo .env
     
     composer install
     
     
 
 * Crear una base de datos 

**mysql -u usuario -p contraseña**
    
**CREATE DATABASE proyecto;**

GRANT ALL PRIVILEGES ON proyecto.* TO 'app'@'localhost' IDENTIFIED BY 'contraseñaweb' WITH GRANT OPTION;
    
**FLUSH PRIVILEGES;**
    

* Modificar archivo .env con los datos de la base de datos
* Ejecutar **php artisan migrate**
* Ejecutar **php artisan db:seed --class=PerfilTableSeeder**
* Ejecutar **php artisan db:seed --class=PerfilMenuTableSeeder**
* Ejecutar **php artisan db:seed --class=MenuTableSeeder**
* Ejecutar **php artisan db:seed --class=UserTableSeeder**

Una vez inicializado el proyecto se puede probar la app colocando el proyecto en una carpeta publica del web server o usando el Web Server integrado de Laravel

**php artisan serve**

ingresar a **http://localhost:8000**

Usar las credenciales 

* Usuario : admin@demo.com
* Contraseña : demo

## Notas importantes

* El proyecto usa Queue y Workers 
* El proyecto usa el driver database para Sessions
* El proyecto incluye Laravel DebugBar
* El proyecto incluye Laravel Stats 

# Software Development (Espacios de México)

## Objective
Start point for web development using Laravel 5.5 framework , with some functional routines, ready to use , like Users CRUD, Profiles CRUD , Permissions and Middleware

## Development Environment (Suggested)
To use this code, you need to use the follow requirements:

* PC or Mac 
* PHP 7.1
* Database Server MySQL 5.7 or higher
* Web Server (Apache 2.2 or NGINX)
* Sequel Pro or MySQL Workbench for MySQL management
* Text Editor or Preferred IDE
* PHP composer
* Homestead for Laravel , the best option

## Project init

* download from GitHub

checklist

      git clone https://danterobles@bitbucket.org/tecnologia-espacios/starterkit55.git
      
     cd starterkit55
         
     cp .env_ejemplo .env
     
     composer install
     
     
 
 * Create database 

**mysql -u usuario -p contraseña**
    
**CREATE DATABASE proyecto;**

GRANT ALL PRIVILEGES ON proyecto.* TO 'app'@'localhost' IDENTIFIED BY 'contraseñaweb' WITH GRANT OPTION;
    
**FLUSH PRIVILEGES;**
    

* Adjust .env file with database settings
* Run **php artisan migrate**
* Run **php artisan db:seed --class=PerfilTableSeeder**
* Run **php artisan db:seed --class=PerfilMenuTableSeeder**
* Run **php artisan db:seed --class=MenuTableSeeder**
* Run **php artisan db:seed --class=UserTableSeeder**

Once the project is initialized you can test the app by placing the project in a public folder of the web server or by using the integrated Laravel Web Server

**php artisan serve**

Go to **http://localhost:8000**

Use this  

* User : admin@demo.com
* Password : demo

## Important

* This project implement Queue & Workers 
* This project use database driver for store session
* This project include Laravel DebugBar
* This project include Laravel Stats

