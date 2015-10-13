It's easy to handle error/exception, find `error_handler` inside **project-name/config/app.php**, by default it should be like this:

```php
'error_handler' => Components\Exceptions\Handler::class,
```

The config above points to the components excception class, let's check that file go to **project-name/components/Exceptions/Handler.php**.

Now let's dig into that class file, we have two(2) functions which it are `report()` and `render($e)`.

Under `report()` function, we're calling the extended parent class, in which we call these PHP Native Functions `register_shutdown_function()`, `set_error_handler()` and `set_exception_handler()`.

Under `render($e)` function, we have plenty of `if` statement that checks the class instance of variable `$e`, such example:

```php
if ($e instanceof AccessNotAllowedException) {
    return (new CsrfHandler)->handle($e);
}
```

The code above passed-in the variable `$e` under `CsrfHandler` class, which you could also check how it prints out the error.
