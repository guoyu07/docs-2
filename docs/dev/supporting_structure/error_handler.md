It's easy to handle errors or exceptions, find the index key `error_handler` inside ``{project-root}/config/app.php``, by default it should be like this:

```php
'error_handler' => Components\Exceptions\Handler::class,
```

<br>

Now open ``{project-root}/components/Exceptions/Handler.php``. This class file has two(2) functions which are `report()` and `render($e)`.

<br>

### Under report()

We're calling the extended parent class, in which we call these PHP Native Functions `register_shutdown_function()`, `set_error_handler()` and `set_exception_handler()`.


### Render

We have plenty of `if` statement that checks the class instance of variable `$e`, such example:

```php
if ($e instanceof AccessNotAllowedException) {
    return (new CsrfHandler)->handle($e);
}
```

The code above passed-in the variable `$e` under `CsrfHandler` class, which you could also check how it prints out the error.
