# Clase 2

## Crear una base de datos sqlite

1. Crear el archivo `database.sqlite` en la raiz de la carpeta `database`.
2. En el archivo `.env` solo dejar el driver en la seccion de la configuración de bases de datos.
3. Ejecutar las migraciones.

## Ejecutar las pruebas

1. Ejecutar el comando `php artisan test --filter=<NombreDelTestTest>`.

# Clase 5

Este paquete proporciona un sistema de autenticación ligero para SPA (aplicaciones de una sola página), aplicaciones móviles y API simples basadas en tokens.

Se puede instalar Laravel Sanctum usando composer en la terminal:

`composer require laravel/sanctum`

Luego se puede publicar el archivo de configuración, ejecutando:

`php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"`

Esto va a crear un archivo llamado sanctum.php en la carpeta config.

Finalmente, para tener las tablas que se necesitan en la base de datos para guardar los tokens. se usan:

`php artisan migrate`

A continuación, si se planea utilizar Sanctum para autenticar un SPA, debe agregar el middleware de Sanctum a su grupo de middleware api dentro de su archivo app/Http/Kernel.php:

```php
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;



'api' => [

EnsureFrontendRequestsAreStateful::class,

'throttle:60,1',

\Illuminate\Routing\Middleware\SubstituteBindings::class,

],
```

Para comenzar a emitir tokens a los usuarios, su mel modelo debe usar el trait HasApiTokens:

```php
use Laravel\Sanctum\HasApiTokens;

  

class User extends Authenticatable

{

use HasApiTokens, Notifiable;

}
```
Para proteger nuestras rutas es tan simple como agregar un middleware.

```php
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

return $request->user();

});
```
Con esto cada vez que ingresemos a esa ruta tendremos que enviar

Afortunadamente, la documentación de Laravel es bastante completa y dentro de ella podremos encontrar mas posibilidades que nos ofrece Sanctum: https://laravel.com/docs/8.x/sanctum
