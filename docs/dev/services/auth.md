This service helps us to authenticate our guest. 

## Index
- [Dependency Injection 'auth'](#dependency-injection)
- [Foundation](#foundation)
    - [Attempt](#attempt)
    - [Check](#check)
    - [Redirect Intended](#redirect-intended)
    - [User](#user)
    - [Destroy](#destroy)

# <a href="#dependency-injection" name="dependency-injection">Dependency Injection 'auth'</a>

There are multiple ways to get this service.

```php
# Through di function helper
$auth = di()->get('auth'); // or di('auth');

# Through function helper
auth()->{function};
```

# <a href="#foundation" name="foundation">Foundation</a>

The lists below are the solid functions that you could use to handle the authentication of the system.

<a href="#attempt" name="attempt"></a>
### Attempt

To attempt to log in, you may follow the code below

```php
$auth->attempt([
    'email' => 'john.doe@example.com',
    'password' => '123qwe',
]);
```

<a href="#check" name="check"></a>
### Check

To check if the user was succesfully attempt to login, you follow the code sample below.

```php
if ($auth>check()) {
    //
}
```

<a href="#redirect-intended" name="redirect-intended"></a>
### Redirect Intended

This will automatically redirect the user once there is a parameter key matching to the config `app.auth.redirect_key`.

E.g, if we have this kind of url requested from the header `http://example.com?ref=http://google.com` the parameter `ref` will be the basis where to redirect the request.

```php
return $auth->redirectIntended();
```

<a href="#user" name="user"></a>
### Get User

To get the authenticated user, you may call the function `user()`, this is based on the class provided, which located at the config `app.auth.model`

```php
$auth->user();
```

<a href="#destroy" name="destroy"></a>
### Destroy

This destroys the current session which removes the current logged-in user.

```php
$auth->destroy();
```
