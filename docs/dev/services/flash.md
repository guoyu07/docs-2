Flash messages are used to notify the user about the state of actions he/she made or simply show information to the users. These kinds of messages can be generated using this component.

This service lives at `Clarity\Providers\Flash.php`.

## Index

- [Flash Types](#flash-types)
    - [Direct](#direct)
    - [Session](#session)
- [Default css classes](#default-css-classes)
- [Change css classes](#change-css-classes)


# <a href="#flash-types" name="flash-types">Flash Types</a>

We have two types of flash, we have the `direct` and `session`. The `direct`
 is useful when calling the dispatcher to forward, and if you planned to use http to redirect, the `session` would probably the best thing to use.

<a name="direct"></a>
## Direct

There are two ways to resolve the service.

```php
di()->get('flash.direct'); # or flash()->direct();
```

#### Example

```php
<?php

use App\Admin\Controllers;

class ContactController extends Controller
{
    public function index()
    {
        // ...
    }

    public function save()
    {
        # store the post
        // ...

        # using direct flash
        flash()->direct()->success("Your information was stored correctly!");

        # forward to the index action
        return dispatcher()->forward(
            [
                "action" => "index"
            ]
        );
    }
}
```

<a name="session"></a>
## Session

There are two ways to resolve the service.

```php
di()->get('flash.session'); # or flash()->session();
```

#### Example

```php
<?php

use App\Admin\Controllers;

class ContactController extends Controller
{
    public function update()
    {
        # update the post
        // ...

        # using session flash
        // flash()->session()->success("Your information was updated!");

        return redirect()->to(url()->previous())
            # or using redirect()->with() uses the flash session too
            ->with('success', 'Your information was updated');
    }
}
```

#### In the view

To print out the the session flash messages, you may call it this way in your template:

**Volt**
```php
{% if flash().session().has('success') %}
    {{ flash().session().output() }}
{% endif %}
```

**Blade**
```php
@if (flash()->session()->has('success'))
    {{ flash()->session()->output() }}
@endif
```

# <a href="#default-css-classes" name="default-css-classes">Default CSS Classes</a>

There are four built-in message types supported:

```php
flash()->session()->error("too bad! the form had errors");
flash()->session()->success("yes!, everything went very smoothly");
flash()->session()->notice("this a very important information");
flash()->session()->warning("best check yo self, you're not looking too good.");
```

You can also add messages with your own types using the `message()`` method:

```php
flash()->session()->message("debug", "this is debug message, you don't say");
```

Messages sent to the flash service are automatically formatted with HTML:

```
<div class="errorMessage">too bad! the form had errors</div>
<div class="successMessage">yes!, everything went very smoothly</div>
<div class="noticeMessage">this a very important information</div>
<div class="warningMessage">best check yo self, you're not looking too good.</div>
```

# <a href="#change-css-classes" name="change-css-classes">Change CSS Classes</a>

To change the class, `extends` the class provider and find the `protected $elements = [];`

```php
<?php

namespace Components\Providers;

use Clarity\Providers\Flash as BaseFlash;

class Flash extends BaseFlash
{
    protected $elements = [
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning',
    ];
}
```

and change the `Flash::class` provided in the `{project-root}/config/app.php` at `services` index.

```php
// ...

'services' => [
    Components\Providers\Flash::class,
    // ...
],

// ...
```
