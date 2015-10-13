Storage is the place we store our compiled views, sessions, caches,  and other 3rd party configurations and so on.

## Index
- [Cache](#cache)
- [Session](#session)
- [Compiled Views](#compiled-views)

---

<a name="cache"></a>
# Cache

If your `cache_adapter` located at `project-name/config/app.php` is equal to **file** that takes the `project-name/storage/cache` folder as your cache storage. You could modify the storage path by changing `adapters.file.options.cacheDir` located at `project-name/config/cache.php`.


---


<a name="session"></a>
# Session

The session has the same process of cache, however it only stores a unique web-browser requests, rather than cache that focuses on global/entire application.

The `session_adapter` by default it is configured as **file** which points to the `session.php` config.


---


<a name="compiled-views"></a>
# Compiled Views

By default we're using ***volt*** as our template engine, if the **debug** is false located at  `project-name/config/app.php`, that means we'll compile the .volt files when they were changed.

If the **debug** is true, we will always compile the .volt files.

All the compiled templates will be stored at `project-name/storage/views/` folder.
