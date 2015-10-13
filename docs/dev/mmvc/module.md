You can learn how to create a new module on your app, we have the `Main` module by default located at `{project-root}/app/Main/`. It contains the routes and controllers to show some sample forms.

## Index:
- [Basic Usage](#basic-usage)

<a name="basic-usage"></a>
## Basic Usage

A good sample would be `admin`, run this script to your command line:

```shell
php brood app:module admin
```

<br/>

There must be generated files, base it to these lists:
- {project-root}/app/Admin/Providers/RouterServiceProvider.php
- {project-root}/app/Admin/Controllers/Controller.php
- {project-root}/app/Admin/Routes/RouteGroup.php
- {project-root}/app/Admin/Routes.php
- {project-root}/public/admin.php

Let's register this class `App\Admin\Providers\RouterServiceProvider::class` as our router service, go to `{project-root}/config/app.php` and find `services`.

```php
return [

    # some code above

    'services' => [
        # some service classes above

        App\Admin\Providers\RouterServiceProvider::class,
    ],

    # some code below
];
```

Setup your `Apache2` or `NginX` to point at `{project-root}/public/admin.php` and we're done! too simple, isn't it?

Try to access your page and it should be working fine.
