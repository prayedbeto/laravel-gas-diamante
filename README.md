Proyecto Laravel para administrar proveedores, ingresos y gastos, con utilidades y reportes básicos.

## Instalación

1. Clona el repositorio y entra al proyecto.
2. Instala dependencias:
   - `composer install`
   - `npm install`
3. Copia el archivo de entorno y genera la key:
   - `cp .env.example .env`
   - `php artisan key:generate`
4. Configura la base de datos en `.env`.
5. Ejecuta migraciones y seeders:
   - `php artisan migrate --seed`
6. Compila assets (o modo dev):
   - `npm run build` o `npm run dev`
7. Levanta el servidor:
   - `php artisan serve`
