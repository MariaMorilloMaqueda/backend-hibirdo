**Aplicación Web Híbrida: Gestión de Libros con OpenLibrary**

Este proyecto es una aplicación web híbrida que combina JavaScript en el frontend, PHP en el backend y un sistema de setup inicial.
La aplicación gestiona un listado de libros almacenados en una base de datos y permite consultar información adicional a través de la API de OpenLibrary.

📚 **Funcionalidades principales**

- 📖 Visualizar el listado de libros disponibles.
- ✏️ Actualizar la información de un libro existente.
- ➕ Añadir un nuevo libro a la base de datos.
- 🔍 Consultar por ISBN: al introducir el código ISBN de un libro, se muestran otros libros del mismo autor desde OpenLibrary.org.

🚀 **Objetivos del proyecto**

- Practicar la integración de frontend y backend en una aplicación web híbrida.
- Conectar la aplicación con una base de datos local para la gestión de libros.
- Aprender a consumir APIs externas (OpenLibrary).
- Implementar operaciones CRUD básicas en PHP.

🛠️ **Tecnologías utilizadas**

- JavaScript (frontend, interacción con el usuario).
- PHP (backend, gestión de la lógica y conexión a la base de datos).
- MySQL (base de datos local para los libros).
- OpenLibrary API (fuente de información externa sobre autores y libros).
- XAMPP (entorno de desarrollo con Apache + MySQL + PHP).

⚙️ **Instalación y ejecución**

1. Clonar el repositorio:
git clone https://github.com/TU-USUARIO/backend.git

2. Colocar el proyecto dentro de la carpeta htdocs de XAMPP.

3. Configurar la base de datos:

- Crear la base de datos en MySQL.
- Ejecutar el script SQL incluido en el proyecto.

4. Iniciar Apache y MySQL desde el panel de XAMPP.

5. Acceder en el navegador:
http://localhost/backend-hibrido/index.html
