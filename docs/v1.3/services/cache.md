It determines your config `project-name/config/app.php` under `cache_adapter`. It iterates all available `adapters` in your `project-name/config/cache.php`.

# Index
- [Basic Usage](#basic-usage)


<a name="basic-usage"></a>
# Basic Usage

You have multiple options to call this service:

```php

# Through di function helper
$cache = di()->get('cache');

# Through function helper
cache()->{function};

# Through Facade
\Cache::{function};
```

Now to store a data:

```php

cache()->save(<key>, <data>); 
```

To get a cache:

```php

cache()->get(<key>);
```

To delete a cache:

```php

cache()->delete(<key>);
```
