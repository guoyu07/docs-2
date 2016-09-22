It determines your config `{project-root}/config/app.php` under `cache_adapter`. It iterates all available `adapters` in your `{project-root}/config/cache.php`. For more [info](#adapters) about adapters.

# Index
- [Foundation](#foundation)
    - [Save](#foundation-save)
    - [Exists](#foundation-exists)
    - [Get](#foundation-get)
    - [Delete](#foundation-delete)
- [Adapters](#adapters)
    - [Frontend](#adapters-frontend)
    - [Backend](#adapters-backend)
        - [File Backend Options](#file-backend-options)
        - [Memcache Backend Options](#memcache-backend-options)
        - [Apc Backend Options](#apc-backend-options)
        - [Mongo Backend Options](#mongo-backend-options)
        - [XCache Backend Options](#xcache-backend-options)
        - [Redis Backend Options](#redis-backend-options)
- [Querying the cache](#querying-the-cache)
- [Life Time](#life-time)

# <a href="#foundation" name="foundation">Foundation</a>

You have multiple options to call this service:

```php
# Through di function helper
$cache = di()->get('cache');

# Through function helper
cache()->{function};
```

<a name="foundation-save"></a>
### Save

```php
cache()->save('key', 'value'); 
```

<a name="foundation-exists"></a>
### Exists

```php
cache()->exists('key');
```

<a name="foundation-get"></a>
### Get

```php
cache()->get('key');
```

<a name="foundation-delete"></a>
### Delete

```php
cache()->delete('key');
```

# <a href="#adapters" name="adapters">Adapters</a>

The caching process is divided into 2 parts.

<a name="adapters-frontend"></a>
### Frontend

This part is responsible for checking if a key has expired and perform additional transformations to the data before storing and after retrieving them from the backend.

| Adapter                         | Description                                                                                                                                                    |
| --------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Phalcon\Cache\Frontend\Output   | Read input data from standard PHP output                                                                                                                       |
| Phalcon\Cache\Frontend\Data     | It’s used to cache any kind of PHP data (big arrays, objects, text, etc). Data is serialized before stored in the backend.                                     |
| Phalcon\Cache\Frontend\Base64   | It’s used to cache binary data. The data is serialized using base64_encode before be stored in the backend.                                                    |
| Phalcon\Cache\Frontend\Json     | Data is encoded in JSON before be stored in the backend. Decoded after be retrieved. This frontend is useful to share data with other languages or frameworks. |
| Phalcon\Cache\Frontend\Igbinary | It’s used to cache any kind of PHP data (big arrays, objects, text, etc). Data is serialized using IgBinary before be stored in the backend.                   |
| Phalcon\Cache\Frontend\None     | It’s used to cache any kind of PHP data without serializing them.                                                                                              |

#### Implementing your own Frontend adapter.

The `Phalcon\Cache\FrontendInterface` interface must be implemented in order to create your own frontend adapters or extend the existing ones.

<a name="adapters-backend"></a>
### Backend

This part is responsible for communicating, writing/reading the data required by the frontend.

| Adapter                         | Description                                    | Info      | Required Extensions  |
| --------------------------------|------------------------------------------------|-----------|----------------------|
| Phalcon\Cache\Backend\File      | Stores data to local plain files               |           |                      |
| Phalcon\Cache\Backend\Memcache  | Stores data to a memcached server              | Memcached | memcache             | 
| Phalcon\Cache\Backend\Apc       | Stores data to the Alternative PHP Cache (APC) | APC       | APC extension        |
| Phalcon\Cache\Backend\Mongo     | Stores data to Mongo Database                  | MongoDb   | Mongo                |
| Phalcon\Cache\Backend\Xcache    | Stores data in XCache                          | XCache    | xcache extension     |
| Phalcon\Cache\Backend\Redis     | Stores data in Redis                           | Redis     | redis extension      |

#### Implementing your own Backend adapters

The `Phalcon\Cache\BackendInterface` interface must be implemented in order to create your own backend adapters or extend the existing ones.

<br>

<a name="file-backend-options"></a>
#### File (Backend) Options

This backend will store cached content into files in the local server. The available options for this backend are.

| Option      | Description                                                   |
|-------------|---------------------------------------------------------------|
| prefix      | A prefix that is automatically prepended to the cache keys    |
| cacheDir    | A writable directory on which cached files will be placed     |

<a name="memcache-backend-options"></a>
#### Memcache (Backend) Options

This backend will store cached content on a memcached server. The available options for this backend are.

| Option      | Description                                                   |
|-------------|---------------------------------------------------------------|
| prefix      | A prefix that is automatically prepended to the cache keys    |
| prefix      | A prefix that is automatically prepended to the cache keys    |
| host        | memcached host                                                |
| port        | memcached port                                                |
| persistent  | create a persistent connection to memcached?                  |

<a name="apc-backend-options"></a>
#### Apc (Backend) Options

This backend will store cached content on Alternative PHP Cache (APC). The available options for this backend are.

| Option      | Description                                                   |
|-------------|---------------------------------------------------------------|
| prefix      | A prefix that is automatically prepended to the cache keys    |

<a name="mongo-backend-options"></a>
#### Mongo (Backend) Options

This backend will store cached content on a MongoDB server. The available options for this backend are.

| Option      | Description                                                   |
|-------------|---------------------------------------------------------------|
| prefix      | A prefix that is automatically prepended to the cache keys    |
| server      | A MongoDB connection string                                   |
| db          | Mongo database name                                           |
| collection  | Mongo collection in the database                              |

<a name="xcache-backend-options"></a>
#### Xcache (Backend) Options

This backend will store cached content on XCache. The available options for this backend are.

| Option      | Description                                                   |
|-------------|---------------------------------------------------------------|
| prefix      | A prefix that is automatically prepended to the cache keys    |

<a name="redis-backend-options"></a>
#### Redis (Backend) Options

This backend will store cached content on a Redis server. The available options for this backend are.

| Option      | Description                                                   |
|-------------|---------------------------------------------------------------|
| prefix      | A prefix that is automatically prepended to the cache keys    |
| host        | Redis host                                                    |
| port        | Redis port                                                    |
| auth        | Password to authenticate to a password-protected Redis server |
| persistent  | Create a persistent connection to Redis                       |
| index       | The index of the Redis database to use                        |

# <a href="#querying-the-cache" name="querying-the-cache">Querying the cache</a>

If you want to know which keys are stored in the cache you could call the `queryKeys()` method.

```php
foreach (cache()->queryKeys() as $cache_key) {
    $data = cache()->get($cache_key);

    echo "Key=", $key, " Data=", $data;
}
```

To get all the keys that starts with `my-prefix`, you may do it this way.

```php
$keys = cache()->queryKeys('my-prefix');
```

# <a href="#life-time" name="life-time">Life Time</a>

By default, we have the `Frontend` adapters to handle the lifetime, we could still achieve this when calling `save()` by providing a third parameter in number of seconds.

```php
cache()->save('key', ['id' => ...[...]], 3600); # store in 1-hour
```
