You've probably learned how to use [Controller](doc:mvc-controller)? Let's try on how explicitly create a route for your modules.

Routing is the place where you define how the system interact with the **URL** requests. Let's assume we have this page to login `example.app/login`.

## Advisable to know these firsts:
- <a target="_blank" href="/docs/mvc-module">Module</a>
- <a target="_blank" href="/docs/mvc-controller">Controller</a>
- <a target="_blank" href="/docs/mvc-view">View</a>

## Index:
- [Basic Usage](#basic-usage)
- [Dynamic Route](#dynamic-route)
- [Naming Route](#naming-route)
- [Route Group](#route-group)
- [Learn More](#learn-more)

<a name="basic-usage"></a>
# Basic Usage
under your **project-name/app/main/routes.php**, let's add this:

```php

route()->addGet('login', [
    'controller' => 'Auth',
    'action'     => 'showLogin',
]);
```

The above code shows how to create a `GET` request, the first parameter is the ```/login``` uri, and if you will be attempting to visit the page ```example.app/login```, the dispatcher will analyze the request **URI**, if found a match, let us say it matches the route above.

The second parameter comes in, which we point it to `Auth` controller and the function `showLogin` will be called.

Go to **project-name/app/main/controllers/AuthController.php** and write the function like below:

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

The above code will be triggered once the url is visited, then we call the `view()` function to show our template engine file.


---


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

The above codes show how to handle url values, so attempting to run this url to your browser `example.app/users/1/edit`.

It should die-and-dump the `$id` which value is **1**.


---


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
Go to **project-name/app/main/routes/UserRoutes.php**, open the file, you should have this defined values.

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

        # - url as users/index
        $this->addGet('/index', [
            'action' => 'index'
        ]);

        # - url as users/store
        $this->addPost('/store', [
            'action' => 'store'
        ]);

        # - url as users/1/show
        $this->addGet('/{id}/show', [
            'action' => 'show'
        ]);

        # - url as users/1/update
        $this->addPost('/{id}/update', [
            'action' => 'update'
        ]);

        # - url as users/1/delete
        $this->addPost('/{id}/delete', [
            'action' => 'delete'
        ]);
    }
}
```

Now register this class in your **project-name/app/main/routes.php**.

```php
route()->mount(new App\Main\Routes\UsersRoutes);
```


Create the `UsersController` at `project-name/app/main/controllers` or execute the brood console command instead.

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
