# Clase 2: Repaso de Laravel y requisitos del curso

## Scaffolding del proyecto

1. Crear ProductControllerTest y crear cada caso de uso para nuestra API de Productos. `php artisan make:test ProductControllerTest`
2. Crea mi modelo Producto con artisan e indicar las flags necesarios para que ademas cree la migracion, factory, seeder y controllador de API con `php artisan make:model Produdct --api --all`
3. Editar migracion de productos para crear la tabla.
4. Crear las rutas y apuntarlas a cada metodo de mi API. Se puede usar `Route::apiResource('products', 'ProductController');`
5. Programar la logica de negocio dentro de ProductController
6. Ir Testeando cada método con ProductControllerTest `vendor/bin/phpunit --filter=ProductControllerTest`

_Reto de la Clase_: Crear Endpoint para Categorias.

## Crear una base de datos sqlite

1. Crear el archivo `database.sqlite` en la raiz de la carpeta `database`.
2. En el archivo `.env` solo dejar el driver en la seccion de la configuración de bases de datos.
3. Ejecutar las migraciones.

## Ejecutar las pruebas

1. Ejecutar el comando `php artisan test --filter=<NombreDelTestTest>`.

# Clase 5: Instalar Laravel Sanctum

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

# Clase 6: API de autenticación: laravel UI y laravel sanctum

## Proteger una ruta con Sanctum

1. En el archivo `routes/api.php` se protege la ruta con el middleware

```php
Route::apiResource('products', 'ProductController')
    ->middleware('auth:sanctum');
```

2. En las pruebas, se tiene que llamar al api de Sanctum en el setUp:

```php
use Laravel\Sanctum\Sanctum;

class ProductControllerTest extends TestCase
{

  protected function setUp(): void
  {
    ...

    Sanctum::actingAs(
        factory(User::class)->create()
    );
```

## Crear token

1. Ejecutar seeders
2. Ejecutar con cliente REST el siguiente llamado:
> POST /api/sanctum/token
> Content-Type: multipart/form-data con email, password, device_name
