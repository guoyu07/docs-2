MVC can be metaphorically related to a TV. You have various channels, with different information on them supplied by your cable provider (the model). **The TV screen displays these channels to you (the view)**. You pressing the buttons on the remote controls affects what you see and how you see it (the controller). -<a href="http://stackoverflow.com/questions/2626803/mvc-model-view-controller-can-it-be-explained-in-simple-terms#answer-2626813">Tilo Mitra</a>

## Index:
- [Controller](#controller)
- [Module](#module)
- [Learn More](#learn-more)

---

<a name="controller"></a>
# Controller

We have a controller actions but wondering how to call our templates.

You have two ways to do that, there is the facade class `View` or you may call the function `view(...)` 

```php
namespace ...;

use View;

class MyController extends Controller
{
    public function index()
    {
        return view('parent_folder.child_folder.file');

        // return View::make('parent_folder.child_folder.file');
    }

    public function users()
    {
        $users = [];
        # some codes here that calls our model
        # and probably passing a data on $users array.

        return view('users.index')
            ->with('users', $users);

            # another way to do it
            // ->withUsers($users);
    }
}
```

The sample code above shows how to call a template or our volt template.

### index() action
Instead of using slash, we're using `dot` to access folders. We have `parent_folder.child_folder.file`, it should access this volt file:
**project-name/resources/view/parent_folder/child_folder/file.volt**

### users() action
To pass in a variable inside the volt or any template engine, we can call this chain function `with('var_name', 1234)`, you could also try the magic method `withVarName(1234)` and it will be interpreted as `$var_name` and the value will be `1234`


---


<a name="module"></a>
# Module

You are wondering how could we change the views directory, we can achieve this by calling `setViewsDir` under our DI `view`

```php
// app/modules.php

return [
    'main' => function (Phalcon\Di\FactoryDefault $di) {
        $di->get('view')->setViewsDir('/going/to/my/separated/folder');
    },
];
```

---


<a name="learn-more"></a>
# Learn More

To learn more about the whole `view` process, you may click these references:
- <a target="_blank" href="https://docs.phalconphp.com/en/latest/reference/views.html">https://docs.phalconphp.com/en/latest/reference/views.html</a>
- <a target="_blank" href="https://docs.phalconphp.com/en/latest/reference/volt.html">https://docs.phalconphp.com/en/latest/reference/volt.html</a>
