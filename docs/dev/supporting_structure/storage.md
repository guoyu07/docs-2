Storage is the place we store our compiled views, sessions, caches,  and other 3rd party configurations and so on.

## Index
- [Cache](#cache)
- [Session](#session)
- [Compiled Views](#compiled-views)

---

<a name="cache"></a>
# Cache

Check your `cache_adapter` at the `{project-root}/config/app.php`, if it is equal to `file`, then that points to the `{project-root}/storage/cache` folder as your cache save path.

You are able to modify the storage path by changing `adapters.file.options.cacheDir` located at the `{project-root}/config/cache.php`.



<a name="session"></a>
# Session

The session has the same process of cache, however it only stores a unique web-browser requests, rather than the cache that focuses on global/entire application.

The `session_adapter` by default is configured as `file` and the adapters are located at the `{project-root}/config/session.php` config.


<a name="compiled-views"></a>
# Compiled Views

By default we're using `volt` as our template engine, if the `debug` is false at the `{project-root}/config/app.php`, that means we'll compile the `.volt` files when they were changed.

If the `debug` is true, we will always compile the `.volt` files, everytime we attempt to refresh a page that generates the volt file.

All the compiled views shall be stored at the `{project-root}/storage/views` folder.
