This page will show you how Slayer's configuration works, that includes the credentials, services, database, queue, sessions and more.

## Index

- [bootstrap/path.php](#path)
- [config/](#config-folder)
    - [app.php](#app)
    - [cache.php](#cache)
    - [consoles.php](#consoles)
    - [database.php](#database)
    - [flysystem.php](#flysystem)
    - [inliner.php](#inliner)
    - [mail.php](#mail)
    - [queue.php](#queue)
    - [script](#script)
    - [services.php](#services)
    - [session.php](#session)

<a name="path"></a>
## bootstrap/path.php

All of slayer classes uses the paths that is located at `{project-root}/bootstrap/path.php`. Those folders are called so that we could easily know the place where we could log/save/update/edit some files and mostly dedicated to our scaffolding that we have.

**Note:** Onload, path is already registered under `config()->path`

----

<a name="config-folder"></a>
## config/

This is located at `{project-root}/config/` directory, by default this folder is a `production` config; to over-ride a config, you should create a new folder like `{project-root}/config/local/` and modify your `.env` file and change `APP_ENV` to local.

To call a configuration, you can use the helper `config()`, to explore more on how to use it, we have few samples below.

#### Example #1:

```php
echo config()->app->lang; // returns 'en'
```

The above code calls the instance `config()` helper. The `app` pulls the `app.php` file, and getting the key `lang` that returns a string value.

#### Example #2:

```php
$swift_config = config()->mail->swift;

var_dump($swift_config);                // returns a stdClass object
var_dump($swift_config->toArray());     // returns an array

echo $swift_config->host;               // returns the host value.
echo $swift_config->toArray()['host'];  // returns the same value but it is an index call
```
The above code shows that if a key has an array value, it will return an object. While you have an option to turn it to an array by calling the function `toArray()`.

#### Example #3:

```php
echo config()->database->adapters->mysql->host;
```
The above code shows a multi chain object call, if we will extract the process:
- calls `config()` instance
- getting `database.php` file
- calling key 'adapters'
- calling key 'mysql'
- getting the value of this key 'host'

----

<a name="app"></a>
### app.php
This config holds most of the application itself, it refers to other config as well, such as `adapters`, `services`, `class aliases` and `http middlewares`.

Let's start and review each keys, the format shows you the first key in the config, it also shows you the default and current value of that key and the type required

| Key                 | Default                       | Type                                                       | Description
| :------------------ | :---------------------------- | :--------------------------------------------------------- | :----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------: |
| **debug**           | true                          | boolean                                                    | This is the setting you will need to set-up to enable debugging on your local or staging server, and disable it when deployed under production server.                                                                               |
| **lang**            | en                            | string                                                     | By default we're using **en** that refers to *english* language in which located at `resources/lang/<folder name>`                                                                                                                 |
| **timezone**        | UTC                           | [timezones](http://php.net/manual/en/timezones.php)        | Timezone to use, helpful when creating records that has timestamp on it such as `created_at`, `updated_at` and `deleted_at`.                                                                                                   |
| **ssl**             | ['main' => false]             | array                                                      | If your module supports ssl, then apply **true** on it, else **false**                                                                                                                                                               |
| **base_uri**        | ['main' => 'slayer.app']      | array                                                      | Set your module's base uri, this is helpful when running command line or using RESTful request                                                                                                                                       |
| **session**         | en                            | string                                                     | Set the session name, this refers to the name found most of the browser's resources                                                                                                                                                  |
| **db_adapter**      | empty                         | string                                                     | Set the database adapter, base it on `config/database.php` under `adapters` key                                                                                                                                                |
| **nosql_adapter**   | mongo1                        | string                                                     | Set the nosql adapter, base it on `config/database.php` under `adapters` key, for now phalcon only supports mongodb for now                                                                                                    |
| **cache_adapter**   | file                          | string                                                     | Caching helps us to determine a global or a system variables; this is also used for storing repetitive sql query, to set the adapter, base it on `config/cache.php` under `adapters` key                                       |
| **queue_adapter**   | beanstalk                     | string                                                     | Queuing helps our system to handle background processes such as sending of emails and many more, to set the adapter base it on `config/queue.php`                                                                                  |
| **session_adapter** | file                          | string                                                     | Sessions is a way to identify a unique requestor per browser, to set the adapter base it on `config/session.php`                                                                                                                   |
| **flysystem**       | local                         | string                                                     | Flysystem is a manager or an instance that follows a single interface of all this multiple adapters/services such as Local/AwsS3/Rackspace/Dropbox/Copy and many more, to set the adapter base it on `config/flysystem.php`        |
| **error_handler**   | `refer to the file`           | class                                                      | The class that handles the thrown exceptions and fatal errors                                                                                                                                                                        |
| **mailer_adapter**  | swift                         | string                                                     | This mail adapter is the one handling the process or way of sending emails, to set the adapter base it on `config/mail.php`                                                                                                        |
| **logging_time**    | hourly                        | "monthly", "daily", "hourly" or false                      | By default it creates a log that appends the current time with the configured value, this way it will help you to divide each logs and find the specific time you want to tail                                                       |
| **auth**            | `refer to the file`           | array                                                      | When authenticating using the service 'auth', you can set the `key` to handler referrer links, on what `model` to use and is the `password` field                                                                              |
| **services**        | `refer to the file`           | array                                                      | This handles all of our dependencies, you can create your own service, to know more please refer to this link [TODO: link to service creation](#link)                                                                                |
| **aliases**         | `refer to the file`           | array                                                      | This is where you can apply an alias class to your facade class or any class you want                                                                                                                                                |
| **middlewares**     | `refer to the file`           | array                                                      | This will be your middleware classes, you can call them by adding a code like this to your controller `$this->middleware('auth')`, to know more please refer to the controller                                                     |


----


<a name="cache"></a>
### cache.php

The table above shows a default value of `file` as our cache adapter.

You could define your own adapter by creating a new set of array. Currently, we have **file**, **redis**, **memcache**, **mongo**, **apc**, **xcache**.

There is a **backend** that refers to the internal process when handling cache data, there is also **frontend** that translates the return cached value.

To learn more about caching, <a href="services-cache.html">click here.</a>

----


<a name="consoles"></a>
### consoles.php

The **Brood** Console helps us to generate files such as modules/controllers, running mail template inliner, applying database migrations, queuing, running scripts and many more.

All the listed classes will be registered upon running `php brood`.

To learn more about console, <a href="misc-brood-console.html">click here.</a>

----

<a name="database"></a>
### database.php

This file handles a relational database, document oriented database and the [phinx migrations](https://github.com/robmorgan/phinx).

**relational database:**

There is a `class` that refers to the adapter to be used when instantiating your models under `{project-root}/components/Models/`.

**document oriented database:**

Currently Phalcon itself only supports MongoDB and the collection mapper is located at `{project-root}/components/Collection`.

**phinx migrations:**

We're using Phinx as our database migration tool that currently works under relational database.

#### To learn more about these:
- Object Relational Mapper
- Object Document Mapper
- Phinx Migrations

----

<a name="flysystem"></a>
### flysystem.php

Initially we're using [Flysystem](https://github.com/thephpleague/flysystem) as our filesystem that supports multiple adapters such as S3, Rackspace, Dropbox, Copy and many more.

To learn more, <a href="#">you may click here.</a>

----

<a name="inliner"></a>
### inliner.php

You're building email templates and those templates only supports inline css, we just want to say, we have this inliner that converts your volt templates into an inline volt file.

We have this default config inside the file.

```php
'registered' => [

    'file' => 'emails/registered',
    'css'  => [
        public_path('css/bootstrap.min.css'),
    ],
],
```


You can try to run `php brood mail:inliner`, the **registered.volt** will be copied and converted as **registered-inlined.volt**

----

<a name="mail"></a>
### mail.php

This config lives in the all the adapters or drivers that slayer supported.

To learn how to send an email, <a href="services-mail.html">you may click here</a>

----

<a name="queue"></a>
### queue.php

This config handles all the adapters of queue, as of now; phalcon only supports **Beanstalkd**, while still adding an initial way to support Redis and many more.

----

<a name="script"></a>
### script.php

You can store repetitive console commands, some of them are to pull an update from master branch and doing some brood console commands, and some of it is to deploy an update from ssh-able server.

To run this, you may call ``php brood run [script key]``, we have some predefined script keys inside this file, we have the **pull** and **deploy**, you can try them out.

----

<a name="services"></a>
### services.php

This config lives most of our services credentials, if you will be checking the file, we have the ``mailgun`` as our example.

----

<a name="session"></a>
### session.php

This config handles all adapters or drivers to support the session handling of slayer, by default we are using **file**
