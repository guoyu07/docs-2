We're building an application that has a single responsibility in which it must be separated under a repetitive calls.

This page helps you to create your own service, or helps you on how to handle a service.

I you'd read the [Module](doc:mvc-module), it has a very simple example on how to create your own service provider.


###  Index
- [Basic Usage](#basic-usage)
- [Relying on a Service](#relying-service)
- [Vendor Publish](#vendor)

---


<a name="basic-usage"></a>
# Basic Usage

To create a service, you must create a class, let's assume we're building a wrapper on a certain library.

Lets use this package `jenssegers/agent` as our example that will be be imported on our project, now we want to easily create a dependency injection for this project rather than having an instance everytime we need it.

```shell
cd /var/www/my-slayer-agent/
mkdir src/
composer init
```

Now manage your composer, write the essential things. Upon doing that you might want to add this to your composer.json

```json
    "autoload": {
        "psr-4": {
            "MySlayerAgent\\Agent\\": "src/"
        }
    }
```

Run the initial `composer dumpautoload` so that it will register as a psr4, it interprets your `src/` folder having this namespace `MySlayerAgent\Agent`. Let's create a class name it as `AgentServiceProvider`

```php
# root-folder/src/AgentServiceProvider.php
namespace MySlayerAgent\Agent;

use Jenssegers\Agent\Agent;
use Clarity\Providers\ServiceProvider;

class AgentServiceProvider extends ServiceProvider
{
    protected $alias = 'agent';
    protected $shared = false;

    public function register()
    {
        return new Agent();
    }
}
```

Register this class inside the `{project-root}/config/app.php` under `services` key, as `MySlayerAgent\Agent\AgentServiceProvider::class`.

The above class will be injected as dependency using the alias `agent`, the `register()` function returns an instance of `\Jenssegers\Agent\Agent` in which you can call using the `di()` function.

```php
di()->get('agent')->is('Windows');
di()->get('agent')->is('Firefox');
di()->get('agent')->is('iPhone');
di()->get('agent')->is('OS X');
di()->get('agent')->isAndroidOS();
di()->get('agent')->isNexus();
di()->get('agent')->isSafari();
di()->get('agent')->isMobile();
di()->get('agent')->isTablet();
di()->get('agent')->match('regexp');
di()->get('agent')->languages();
```

You could even create your own facade.

```php
# root-folder/src/AgentFacade.php
namespace MySlayerAgent\Agent;

use Clarity\Facades\Facade;

class AgentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'agent';
    }
}
```

Register it as well at `app.php` config as `'Agent' => MySlayerAgent\Agent\AgentFacade::class`

Now you can easily call it through this

```php
\Agent::is('Windows');
\Agent::is('Firefox');
\Agent::is('iPhone');
\Agent::is('OS X');
\Agent::isAndroidOS();
\Agent::isNexus();
\Agent::isSafari();
\Agent::isMobile();
\Agent::isTablet();
\Agent::match('regexp');
\Agent::languages();
```

---


<a name="relying-service"></a>
# Relying on a Service

To rely on other services, there is a `boot()` function that you could call.

```php
    public function boot()
    {
        # add some event manager and so on ...
        // di()->get('log')->...
    }
```

There is also an example, find at `{project-root}/components/Providers/`, check the `Application.php` and `Dispatcher.php`, we call the dependency injection itself to create an event.

#### Application.php:

```php
    public function boot()
    {
        $app = di()->get('application');

        $event_manager = new EventsManager;

        $event_manager->attach('application', new ApplicationEventListener);

        $app->setEventsManager($event_manager);
    }
```


---

<a name="vendor"></a>
# Vendor Publish

So you have files that you want to import from the root path of your project. There is an option to do that.

Under `boot()` function, you can call the `publish(<array folders>, <tag name>)` command.

```php
    public function boot()
    {
        $this->publish([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/popeye'),
        ], 'view');
    
        $this->publish([
            __DIR__.'/dist' => base_path(),
        ], 'dist');
    }
```

The above code shows, on how you could publish your folders. Try to run this on your console. Here's the console format `php brood vendor:publish <provider alias>`, and there is a *tag* option.

```php
php brood vendor:publish popeye
```

The above console command will iterate all the registered tags and requires you to confirm one-by-one.

To make a specific publish, you can add `--tag` in the command

```php
php brood vendor:publish popeye --tag=dist
```
