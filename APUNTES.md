# Clase 2: Repaso de Laravel y requisitos del curso

## Scaffolding del proyecto

1. Crear ProductControllerTest y crear cada caso de uso para nuestra API de Productos. `php artisan make:test ProductControllerTest`
2. Crea mi modelo Producto con artisan e indicar las flags necesarios para que ademas cree la migracion, factory, seeder y controllador de API con `php artisan make:model Product --api --all`
3. Editar migracion de productos para crear la tabla.
4. Crear las rutas y apuntarlas a cada metodo de mi API. Se puede usar `Route::apiResource('products', 'ProductController');`
5. Programar la logica de negocio dentro de ProductController
6. Ir Testeando cada método con ProductControllerTest `vendor/bin/phpunit --filter=ProductControllerTest`

_Reto de la Clase_: Crear Endpoint para Categorias.

## Crear una base de datos sqlite

1. Crear el archivo `database.sqlite` en la raiz de la carpeta `database`.
2. En el archivo `.env` solo dejar el driver en la seccion de la configuración de bases de datos y cambiar la variable **DB_CONNECTION=sqlite**
3. Ejecutar las migraciones.

## Ejecutar las pruebas

Ejecutar el comando `php artisan test --filter=<NombreDelTestTest>`.

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

Afortunadamente, la documentación de Laravel es bastante completa y dentro de ella podremos encontrar mas posibilidades que nos ofrece Sanctum: https://laravel.com/docs/7.x/sanctum

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

# Clase 7: Capa de transformación con API Resources

## Resources

Son herramientas muy parecidos a los mappers, se invocan con:
`php artisan make:resource <NombreDelRecurso>`

## Requests

Son herramientas que permiten hacer validaciones y aplicar middlewares desde el _request_ y no en la capa de controlador, se invocan con:
`php artisan make:request <NombreDelRequest>`

# Clase 9: Relaciones Polimórficas en Eloquent

## Traits

Es un método para reutilizar métodos en clases independientes.

# Clase 10: Cómo crear comandos para la terminal de Laravel

## Comandos

`php artisan make:command <NombreDelComando>`

## Notificaciones

`php artisan make:notification <NombreDeLaNotificacion>`

# Clase 12: Programación de tareas

## Schedule

Sirve para ejecutar tareas programadas, estas se deben llamar en un cron en el servidor.

`php artisan schedule:run`

# Clase 13: Eventos y Listeners en Laravel

## Eventos/Listeners

Se disparan cuando se realiza una operación (generalmente en los modelos/controladores).

- `php artisan make:event <NombreDelEvento>`
- `php artisan make:listener <NombreDelListener>`

# Clase 15: Introducción al uso de Queues y Jobs

## Queues y Jobs

Los Jobs son tareas que se realizan de manera asincrona, almacenados en una cola, y entregan respuesta inmediata al usuario.
https://laravel.com/docs/7.x/queues

1. `php artisan queue:table`
2. `php artisan migrate`
3. Env: QUEUE_CONNECTION=database
4. `php artisan make:job <NombreDelJob>`
5. `php artisan queue:listen`

## Emails

Son plantillas de correo que reciben parámetros y los imprimen en una vista.
`php artisan make:mail <NombreDeLaPlantilla>`

## Cuando usar queue:work y cuándo queue:listen

Para ambientes productivos la recomendación es trabajar con **queue:work** ya que la ejecución de los jobs se hace de manera más eficiente (hay datos de la aplicación claves para ello que se almacenan en memoria).
Para ambientes en local la recomendación es trabajar con **queue:listen**, de esta forma los cambios que se hacen en el desarrollo involucrado se reflejarán automáticamente (no hay información que se guarde en memoria).

# Clase 16: Cómo disparar eventos en Queues

Para que un evento se dispare desde un Job en una cola, el evento debe implementar la interfaz: _ShouldQueue_.

# Clase 19: Excepciones personalizadas

https://laravel.com/docs/7.x/errors

## Usar configuraciones

1. Crear archivo dentro de la carpeta **/config**
2. Llamar con

```php
config("<archivo>.<key>");
```

## Usar translaciones

1. Crear archivo dentro de la carpeta **/resources/lang/<IdiomaNavegador>**
2. Llamar con

```php
trans("<archivo>.<key>", ["paramero" => $valor]);
```

# Clase 21: Configuración de logs y channels en Laravel

https://laravel.com/docs/7.x/logging

## Thinker

Es una utilidad CLI que permite ejecutar código php relacionado con Laravel, como helpers.
`php artisan tinker`

## Logger

Es una manera simple de escribir hacia los logs de la aplicacion.

```php
logger()->error('Ejemplo');
```

## Politicas de autenticación
