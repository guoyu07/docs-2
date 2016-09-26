The url service, handles the manipulation of our module's url.

# Generate from Route Name

Assume that we have this route declared on the top of our module.

```php
Route::add('tickets/{id}', [
    'controller' => 'Ticket',
    'action' => 'show',
])->setName('showTicket');
```

and using url's route to generate from it.

```php
$params = ['id' => 1];

echo url()->route('showTicket', $params);
```

The above code should generate a url like `http://slayer.app/tickets/1`.

Now add a third parameter to have some `GET` parameters style.

```
$raw = ['callBack' => 'json'];
echo url()->route('showTicket', $params, $raw);
```

The above should generate a url like this `http://slayer.app/tickets/1?callBack=json`.

# Helpers

#### To build a uri.

```php
# http://slayer.app/newsfeed/today
url()->to('newsfeed/today');
```

#### To get current url.
```php
# http://slayer.app/auth/login
url()->current();
```

#### To get previous url

```php
# http://slayer.app/
url()->previous();
```

#### Get Scheme

```php
# http
url()->getScheme($module = null);
```

If running thru browser, it will detect if you are under `https` protocol. If you are calling this thru command line interface (cli), it will automatically force things and provide `http` protocol instead.

Passing the `module` name in the parameter:

- If under browser
    - it will first detect if you are using https, if not, it will rely on the `config/app.php` under `ssl` key if the module was set and assigned as `true`
- if under cli
    - it will rely on the config

#### Get Host

```php
# slayer.app
url()->getHost($module = null);
```

The logic behind getting scheme is almost the same with the host, it will always provide an `http` if running under cli, unless a config was assign at `config/app.php` under hosts `base_uri`.

#### Get Full Url

```php
url()->getFullUrl($module = null);
```

Getting the full url is combined with the scheme and host along the logic of it.

# Customize

You can override the base uri that was automatically applied by calling `setBaseUri`.

```php
# a folder if needed?
url()->setBaseUri('/var/www/slayer/');

# a cdn type domain
url()->setBaseUri('//phalconslayer.com/');

# a domain with path
url()->setBaseUri('http://phalconslayer.com/assets/');
```

To add a path for different type of base uri, you may do it this way.

```php
url()->setBaseUri('/var/www/');
echo url()->get('slayer/app');
```