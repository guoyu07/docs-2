MVC can be metaphorically related to a TV. You have various channels, with different information on them supplied by your cable provider (the model). The TV screen displays these channels to you (the view). **You pressing the buttons on the remote controls affects what you see and how you see it (the controller)**. -<a href="http://stackoverflow.com/questions/2626803/mvc-model-view-controller-can-it-be-explained-in-simple-terms#answer-2626813">Tilo Mitra</a>

## Index:
- [Generate New Controller](#generate-new-controller)
- [Basic Routing](#basic-routing)
- [Middleware](#middleware)

<a name="generate-new-controller"></a>
# Generate New Controller

Run this to your console
```shell
php brood app:controller Ticket main
```

The above console command creates a `TicketController` under the `main` module.

There must be a file located at `app/main/controllers/TicketController.php`

<a name="basic-routing"></a>
# Basic Routing

Let us say we're using a different domain that points to `main` module, example `http://www.flavoredtickets.com`, and we want to have a new route, the route file must be located at `app/main/routes.php`

```php
Route::addGet('/new', [
    'controller' => 'Ticket',
    'action' => 'new',
]);

Route::addPost('/create', [
    'controller' => 'Ticket',
    'action' => 'create',
]);

Route::addPost('/update/{id}', [
    'controller' -> 'Ticket',
    'action' => 'update',
]);

Route::any('/delete/{id}', [
    'controller' => 'Ticket',
    'action' => 'delete',
]);
```

|Verb          |URI           |Desc                                                                                               |
|--------------|--------------|---------------------------------------------------------------------------------------------------|
|`GET`       | /new         |The `TicketController` will be instantiated and the function `new()` will be called            |
|`POST`      | /new         |The `TicketController` will be instantiated and the function `create()` will be called         |
|`POST`      | /update/1    |The `TicketController` will be instantiated and the function `update($id)` will be called      |
|`GET` or `POST`       | /delete/1    |The `TicketController` will be instantiated and the function `delete($id)` will be called      |

The above table shows you how the request and uri processes along the Controller class. <a target="_blank" href="/docs/supporting-structure-routing">To know more about routing, click here.</a>


---

<a name="middleware"></a>
# Middleware

```php
# namespace/use code here

class TicketController extends Controller
{
    public function initialize()
    {
        $this->middleware('csrf', [
            'only' => [
                'create',
            ],
        ]);
    }

    # some functions below
}
```

The code above shows how to call a middleware, Phalcon uses `__construct()` as final function in it, however they added a new function called `initialize()`, this function was called after the instantiation of the class.

We have a parent function called `$this->middleware($alias, $options = [])`, the alias is located at `project-name/config/app.php` under `midlewares`.

We're calling `'csrf'` key, if the dispatched route points to `create()` function. The class will be called and it is located at `project-name/components/Middleware/CSRF.php` that has this kind of code:

```php
namespace Components\Middleware;

use Clarity\Exceptions\AccessNotAllowedException;

class CSRF implements \League\Tactician\Middleware
{
    public function execute($request, callable $next)
    {
        if ( $request->isPost() ) {

            if ( security()->checkToken() === false ) {

                # - throw exception or redirect the user
                # or render a content using
                # View::take(<resources.view>);exit;

                throw new AccessNotAllowedException('Token mismatch, what are you doing?');
            }
        }

        return $next($request);
    }
}
```

Can you guess the above code?

It validates your request if it is POST and it validates the csrf token from the form if it is correct, else it will throw an `AccessNotAllowedException`
