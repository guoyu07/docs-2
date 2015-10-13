**<a href="http://google.com/search?q=what+is+module" target="_blank">What is module all about?</a>**
In real world scenarios, we're building applications that communicates or uses the same resources, most probably you're building a large web application that must be divided into a different module, such as `admin`, `white label`, `social network manager`, `online payment manager` and anything you think you must separate it from your current module.


## Index:
- [Basic Usage](#basic-usage)
- [Alternative as a Service](#alternative-service)


<a name="basic-usage"></a>
# Basic Usage

Let us say, we want an `admin` module.

Run this to your console:
```
php brood app:module admin
```

There must be generated directory and files, base it to these locations:
- project-name/app/admin/
- project-name/public/admin.php

We must register our module on a manual way, write this to the file located at `project-name/app/modules.php`.

``` php 
return [
    # some array of modules above

    'admin' => function (Phalcon\Di\FactoryDefault $di) {
        $di->get('dispatcher')->setDefaultNamespace('App\Admin\Controllers');
    },
];
```

We called the service `dispatcher`, we've changed the default namespace to understand the namespace of our controller, this also helps the modules' router to be configured automatically.

Setup your **Apache2** or **NginX** to point at `project-name/public/admin.php` and we're done! That's too simple, isn't it? Let's try below section as an alternative way.


<a name="alternative-service"></a>
# Alternative as a Service

```php
namespace Popeye\Admin;

use Phalcon\Di\FactoryDefault;
use Clarity\Providers\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    protected $alias = 'admin';
    protected $shared = false;

    private function getClosure()
    {
        return function (FactoryDefault $di) {
            $di->get('dispatcher')
               ->setDefaultNamespace('Popeye\Admin\App\Controllers');
        };
    }

    public function register()
    {
        di()->get('module')->setModule(
            $this->alias,
            $this->getClosure()
        );

        return $this;
    }
}
```


The above code shows you how to include your module by calling `di()->get('module')->setModule(<name>, <closure>)`

Let's register this class as our service, go to `project-name/config/app.php` and find `services`, include your class.

```php
return [

    # some code above

    'services' => [
        # some service classes above

        Popeye\Admin\AdminServiceProvider::class,
    ],
    
    # some code below
];
```

try to access your page and it should be working fine.

# Sample Service Modules

- <a target="_blank" href="https://github.com/daison12006013/phalconslayer-admin">https://github.com/daison12006013/phalconslayer-admin</a>
