### YouTube-Laravel

# Los usuarios pueden:
-   Subir vídeos
-   Ver vídeos de otros usuarios
-   Buscar por etiquetas
-   Suscribirse a otros canales
-   Ver rankings con los mejores vídeos y canales

# Tecnologías utilizadas
-   Laravel. No hay separación entre Front y Back end. Utilizado tanto para las vistas como para la lógica del servidor
-   jQuery para la subida asíncrona de vídeos
-   Videojs (https://videojs.com/) para el reproductor de vídeo
-   Fontawesome (https://fontawesome.com/) para los iconos de la página

# Instalación
-   Descarga el repositorio y modifica el archivo .env para incluir los siguientes parámetros:
        +Host, puerto, nombre, usuario y contraseña de la Base de Datos (debe estar vacía).
        +Access Key, Secret Key, Default Region y Bucket de un servidor S3 de Amazon Web Services.
        +Ruta a FFMPEG y FFPROBE una vez instalado FFMPEG en el equipo. Ejemplo para Ubuntu 20.04:
            FFMPEG="/usr/bin/ffmpeg"
            FFPROBE="/usr/bin/ffprobe"
-   Ejecuta el comando "composer install"
-   Ejecuta el comando "php artisan migrate" en el directorio del proyecto.
-   Si no tienes el proyecto desplegado en un servidor, ejecuta "php artisan migrate" para lanzarlo en desarrollo.

© Daniel Sánchez Checa
