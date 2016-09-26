This page should show you how to call the view service.

# Index

# Basic Usage

You may call the `view()` helper inside controller, see below code on how you can call a volt file.

```
class DashboardController ...
{
    public function index()
    {
        return view('dashboard');
    }
...
```

The above sample code will basically call a `volt` file or any template engine you have, located at `resources/views/dashboard.volt`

# Passing variable/s to view

```
return view('users.profile', ['name' => 'John Doe']);
```

Now the above code passes the value 'John Doe' as `$name` in the volt file located at `resources/views/users/profile.volt`

# View's Take

Sometimes we just want to grab the content, and pass it as jSON, or for some reason on other scenarios that you want to take the content, check below sample code.

```
$details = view(`products.details`)->take();

return response()->setJsonContent(['details' => $details]);
```

The above code will gonna take the `products/details.volt` content and passed in the `$details`. Moreover, we called the `response()` helper to render it as jSON content.

The header's content-type will automatically changed back to its default  value as `application/json` with charset of utf-8.

