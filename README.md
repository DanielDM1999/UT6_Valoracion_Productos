# UT6 - Sistema de Valoración de Productos - Electrónica OnLine

## Introducción

Este proyecto es una aplicación web completa para una tienda en línea llamada Electrónica OnLine. Esta aplicación utiliza una base de datos MySQL para almacenar información sobre usuarios, productos y las valoraciones que los usuarios pueden hacer sobre dichos productos.

Desarrollado por: Daniel Delgado Meneses

## Características Principales

1. **Sistema de Autenticación**: Los usuarios pueden registrarse e iniciar sesión. El sistema distingue entre usuarios normales y administradores.
2. **Gestión de Productos**:
   - Listado de Productos: Los usuarios autenticados pueden ver una lista completa de productos disponibles.
   - Creación de Productos: Los administradores pueden añadir nuevos productos al catálogo.
   - Edición de Productos: Los administradores pueden modificar la información de los productos existentes.
   - Eliminación de Productos: Los administradores tienen la capacidad de eliminar productos del catálogo.
3. **Sistema de Valoración**: Los usuarios pueden valorar los productos utilizando un sistema de estrellas (de 1 a 5).
4. **Visualización de Valoraciones**: El sistema muestra la valoración promedio de cada producto y el número total de valoraciones recibidas.
5. **Interfaz Responsiva**: La aplicación utiliza Tailwind CSS para proporcionar una interfaz de usuario moderna y responsiva.

## Estructura del Proyecto

- `config/`
  - `Database.php`: Clase para la conexión a la base de datos.
- `controllers/`
  - `UserController.php`: Maneja la lógica de negocio relacionada con los usuarios.
  - `ProductController.php`: Maneja la lógica de negocio relacionada con los productos.
- `models/`
  - `User.php`: Define la estructura y operaciones de base de datos para los usuarios.
  - `Product.php`: Define la estructura y operaciones de base de datos para los productos.
- Archivos principales:
  - `index.php`: Página de inicio y registro de usuarios.
  - `login.php`: Maneja la autenticación de usuarios.
  - `logout.php`: Cierra la sesión del usuario.
  - `listado.php`: Muestra la lista de productos y permite a los usuarios valorarlos.
  - `crear.php`: Permite a los administradores crear nuevos productos.
  - `editar.php`: Permite a los administradores editar productos existentes.
  - `eliminar.php`: Permite a los administradores eliminar productos.
  - `detalle.php`: Muestra los detalles de un producto específico.
  - `votar.php`: Procesa las valoraciones de los usuarios.
  - `valoracion.php`: Actualiza y muestra las valoraciones de los productos.
- `database.sql`: Script SQL para crear la estructura de la base de datos.

## Tecnologías Utilizadas

- PHP (con estructura MVC simplificada)
- MySQL
- JavaScript y Ajax
- Tailwind CSS

## Instalación y Configuración

1. Instale XAMPP en su ordenador si aún no lo tiene instalado.
2. Clone o descargue este repositorio en la carpeta `htdocs` de su instalación de XAMPP (usualmente en `C:\xampp\htdocs\` en Windows o `/Applications/XAMPP/htdocs/` en macOS).
3. Inicie los servicios de Apache y MySQL desde el panel de control de XAMPP.
4. Abra phpMyAdmin accediendo a `http://localhost/phpmyadmin` en su navegador.
5. Cree una nueva base de datos para el proyecto.
6. Importe el archivo `database.sql` en la base de datos recién creada para establecer la estructura necesaria.
7. Configure los detalles de conexión a la base de datos en el archivo `config/Database.php`. Asegúrese de que el nombre de la base de datos, el usuario y la contraseña coincidan con su configuración local de XAMPP.
8. Acceda a la aplicación a través de su navegador web visitando `http://localhost/nombre-de-su-carpeta-de-proyecto`.

Nota: Asegúrese de que su instalación de XAMPP tenga PHP y las extensiones necesarias habilitadas. Puede verificar esto en el archivo `php.ini` o a través del panel de control de XAMPP.

## Uso

1. Acceda a la aplicación a través de su navegador web.
2. Regístrese como nuevo usuario o inicie sesión si ya tiene una cuenta.
3. Explore el catálogo de productos, vea detalles y deje valoraciones.
4. Los administradores pueden gestionar el catálogo de productos (crear, editar, eliminar).

