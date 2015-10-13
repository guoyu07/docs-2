This provider helps us to have an access to this class `Clarity\Support\Auth\Auth`

The sample module `main` uses some of the defined functions, such as:

```php
$auth = di()->get('auth');


# to loging the user, provide the fields needed, along the password field
$auth->attempt([
    'email' => 'john.doe@example.com',
    'password' => '123qwe',
]);


# to determine if the current sesssion has some
# logged-in record
if ($auth->check()) {
    // ...
}


# to redirect the user if a key given in the url
return $auth->redirectIntended();


# to get the current user information
$auth->user();


# to destroy the current logged-in record
$auth->destroy();
```

This provider determines your config `project-name/config/app.php` under `auth` key
