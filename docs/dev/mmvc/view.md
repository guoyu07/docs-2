MVC can be metaphorically related to a TV. You have various channels, with different information on them supplied by your cable provider (the model). **The TV screen displays these channels to you (the view)**. You pressing the buttons on the remote controls affects what you see and how you see it (the controller). -<a href="http://stackoverflow.com/questions/2626803/mvc-model-view-controller-can-it-be-explained-in-simple-terms#answer-2626813">Tilo Mitra</a>

## Index:
- [Controller](#controller)
- [Passign Variables to Templates](#passing-variables)
    - [Specific](#passing-variables-specific)
    - [Global](#passing-variables-global)
- [Learn More](#learn-more)

# <a href="#controller" name="controller">Controller</a>

We have `view(path.to.template)` function to get a view's content.

```php
namespace App\Admin\Controllers;

class MyController extends Controller
{
    public function index()
    {
        return view('parent_folder.child_folder.file');
    }
}
```

The sample code above shows how to call a template. We're using `dot` to access folders in which we have the `parent_folder.child_folder.file`, it should access this file located at the
`{project-root}/resources/view/parent_folder/child_folder/file.{volt or blade.php}`

# <a href="#passing-variables" name="passing-variables">Passing Variables to Templates</a>

To have a variable to be passed on a template, we have options on how we could do it.

<a name="passing-variables-specific"></a>
### Specific

```
public function users()
{
    return view('users.index')
        ->with('users', $users);
        # alternative way to do assign
        // ->withUsers($users);

        # or a batch assignment
        // ->batch([
        //     'variable1' => 'value1',
        //     'variable2' => ['value2 as an array'],
        // ]);
}
```

<a name="passing-variables-global"></a>
### Global

```
public function __construct()
{
    # global assignment
    view()->setVar('users', $users);

    # global batch assignment
    view()->setVars([
        'variable1' => 'value1',
        'variable2' => ['value2 as an array'],
    ]);

    return view('users.index');
}
```

# <a href="#learn-more" name="learn-more">Learn More</a>

Available Templates:
- <a href="templates-volt.html">Volt</a>
- <a href="templates-blade.html">Blade</a>
