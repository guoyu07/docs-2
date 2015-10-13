#### Reference:

- <a target="_blank" href="/docs/mvc-module">Module</a>
- <a target="_blank" href="/docs/mvc-controller">Controller</a>
- <a target="_blank" href="/docs/mvc-view">View</a>

## Index:
- [Basic Usage](#basic-usage)
- [Parameters with Names](#parameters-with-names)
- [Dynamic Route](#dynamic-route)
- [Naming Route](#naming-route)
- [Route Group](#route-group)
- [Learn More](#learn-more)

---

<a name="basic-usage"></a>
# Basic Usage

under your ``{project-root}/app/Main/Routes.php``, let's add this:

```php
Route::addGet('login', [
    'controller' => 'Auth',
    'action'     => 'showLogin',
]);
```

The above code shows how to create a `GET` request, the first parameter is the `/login` uri. The second parameter will be the route attributes, such as controller `Auth` and the action `showLogin`.

<br>

Go to ``{project-root}/app/Main/Controllers/AuthController.php`` and write the function like below:

```php
namespace App\Main\Controllers;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
}
```

The above code will be triggered once the url is visited, then we call the `view()` function to show our template located at ``{project-root}/app/resources/views/auth/login.volt``


<a name="dynamic-route"></a>
# Dynamic Route

You've learned the basic, now let's move on to this dynamic route.

```php
route()->addGet('users/{id}/edit', [
    'controller' => 'User',
    'action'     => 'edit',
]);
```

and here is the controller sample

```php
namespace App\Main\Controllers;

class UserController extends Controller
{
    public function edit($id)
    {
        # do a model query using the $id passed in
        dd($id);
    }
}
```

The above codes shows how to handle url values, so attempting to run this url to your browser `example.app/users/1/edit`.

It should die-and-dump the `$id` which value is `1`.

<br>

An application can have many paths and defining routes one by one can be a cumbersome task. In these cases we can create more flexible routes:

```php
Route::add('/admin/:controller/a/:action/:params', [
    "controller" => 1,
    "action"     => 2,
    "params"     => 3
]);
```

In the example above, we’re using wildcards to make a route valid for many URIs. For example, by accessing the following URL `/admin/users/a/delete/dave/301` would produce:

| Controller | users  |
|------------|--------|
| Action     | delete |
| Parameter  |  dave  |
| Parameter  |  301   |

The add() method receives a pattern that can optionally have predefined placeholders and regular expression modifiers. All the routing patterns must start with a forward slash character (/). The regular expression syntax used is the same as the <a target="_blank" href="http://php.net/manual/en/book.pcre.php">PCRE regular expressions</a>. Note that, it is not necessary to add regular expression delimiters. All route patterns are case-insensitive.

The second parameter defines how the matched parts should bind to the controller/action/parameters. Matching parts are placeholders or subpatterns delimited by parentheses (round brackets). In the example given above, the first subpattern matched (:controller) is the controller part of the route, the second the action and so on.

These placeholders help writing regular expressions that are more readable for developers and easier to understand. The following placeholders are supported:


| Placeholder          | Regular Expression          | Usage                                                                                                  |
|----------------------|-----------------------------|--------------------------------------------------------------------------------------------------------|
| `/:module`           | `/([a-zA-Z0-9\_\-]|)`       | Matches a valid module name with alpha-numeric characters only                                         |
| `/:controller`       | `/([a-zA-Z0-9\_\-]|)`       | Matches a valid controller name with alpha-numeric characters only                                     |
| `/:action`           | `/([a-zA-Z0-9\_]|)`         | Matches a valid action name with alpha-numeric characters only                                         |
| `/:params`           | `(/.*)*`                    | Matches a list of optional words separated by slashes. Only use this placeholder at the end of a route |
| `/:namespace`        | `/([a-zA-Z0-9\_\-]|)`       | Matches a single level namespace name                                                                  |
| `/:int`              | `/([0-9]|)`                 | Matches an integer parameter                                                                           |


<a name="parameters-with-names"></a>
### Parameters with Names

The example below demonstrates how to define names to route parameters:

```php
Route::add('/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params', [
    "controller" => "posts",
    "action"     => "show",
    "year"       => 1, // ([0-9]{4})
    "month"      => 2, // ([0-9]{2})
    "day"        => 3, // ([0-9]{2})
    "params"     => 4  // :params
]);
```

In the above example, the route doesn’t define a “controller” or “action” part. These parts are replaced with fixed values (“posts” and “show”). The user will not know the controller that is really dispatched by the request. Inside the controller, those named parameters can be accessed as follows:

```php
namespace App\Main\Controllers;

class PostsController extends Controller
{
    public function indexAction()
    {
    }

    public function showAction()
    {
        // Get "year" parameter
        $year = dispatcher()->getParam("year");

        // Get "month" parameter
        $month = dispatcher()->getParam("month");

        // Get "day" parameter
        $day = dispatcher()->getParam("day");

        // ...
    }
}
```

Note that the values of the parameters are obtained from the dispatcher. This happens because it is the component that finally interacts with the drivers of your application. Moreover, there is also another way to create named parameters as part of the pattern:

```php
Route::add('/documentation/{chapter}/{name}.{type:[a-z]+}', [
    "controller" => "documentation",
    "action"     => "show"
]);
```

You can access their values in the same way as before:

```php
namespace App\Main\Controllers;

class DocumentationController extends Controller
{
    public function showAction()
    {
        // Get "name" parameter
        $name = dispatcher()->getParam("name");

        // Get "type" parameter
        $type = dispatcher()->getParam("type");

        // ...
    }
}
```

<a name="naming-route"></a>
# Naming Route

Let's extend more about the `login` uri by adding **addPost** also.

Add a `setName(<name>)` chain on it.

```php
route()->addPost('login', [
    'controller' => 'Auth',
    'action'     => 'attemptLogin',
])->setName('attemptLogin');
```

In your `controller` or `view`, you may call the function `route('showLogin')` to return the full url.

```php
// ...
class ... extends ...
{
    public function showLogin()
    {
        $post_login_url = route('attemptLogin'); // example.app/login

        return view('auth.showLogin')
            ->withPostLoginUrl($post_login_url);
    }

    public function attemptLogin()
    {
        // code...
    }
}
```

The code above shows how to get the full url by just getting the route name.

How about the route `users/{id}/edit`, let's inject a name **userEdit** in it, and call it this way by providing the `id` in the second parameter.

```php
echo route('userEdit', [
    'id' => 100,
]);
```

It must return `example.app/users/100/edit`.


---


<a name="route-group"></a>
# Route Group

Route group is much more cleaner to use if you want to separate a scope into a class registrar
- having a url like this `http://example/users/../..` into **UsersRoute** class
- as well `http://example/auth/..` into **AuthRoute** class

Run this to your console:
```shell
php brood app:route Users main
```

```shell
> Crafting Route...
>    UsersRoutes.php created!
> Generating autoload files
```

The above command generates a **UsersRoutes.php** inside your ***main*** module.
Go to **{project-root}/app/Main/Routes/UserRoutes.php**, open the file, you should have this defined values.

```php
namespace App\Main\Routes;

class UsersRoutes extends RouteGroup
{
    public function initialize()
    {
        $this->setPaths([
            'namespace' => 'App\Main\Controllers',
            'controller' => 'Users',
        ]);

        $this->setPrefix('/users');

        # url as users/index
        $this->addGet('/index', [
            'action' => 'index'
        ]);

        # url as users/store
        $this->addPost('/store', [
            'action' => 'store'
        ]);

        # url as users/1/show
        $this->addGet('/{id}/show', [
            'action' => 'show'
        ]);

        # url as users/1/update
        $this->addPost('/{id}/update', [
            'action' => 'update'
        ]);

        # url as users/1/delete
        $this->addPost('/{id}/delete', [
            'action' => 'delete'
        ]);
    }
}
```

Now register this class in your **{project-root}/app/Main/Routes.php**.

```php
route()->mount(new App\Main\Routes\UsersRoutes);
```


Create the `UsersController` at `{project-root}/app/Main/Controllers` or execute the brood console command instead.

```php
namespace App\Main\Controllers;

class UsersController extends Controller
{
    // add a function
}
```

That's it, and you should have a simple resource URL.
- /users/index
- /users/store
- /users/{id}/show
- /users/{id}/update
- /users/{id}/deleted


---


<a name="learn-more"></a>
# Learn More

To learn more, I have this reference that shows how fully Phalcon routing works.
- <a target="_blank" href="https://docs.phalconphp.com/en/latest/reference/routing.html">https://docs.phalconphp.com/en/latest/reference/routing.html</a>
