Unit testing and along functional testing is where we test the stability of our code. We've imported the PHPUnit as the main unit testing tool of Slayer.

## Index
- [Example Scenario](#example-scenario)
- [The Tool](#the-tool)


---


<a name="example-scenario"></a>
# Example Scenario

Let us assume that we have a large project that doesn't apply any Unit/Functional Testing or any kind of BDD/TDD/DDD implementations.

Now you modified a certain class, and that class is our "Model", let us assume we have User class, which handles the login process, then we changed the field from `email` to `username`.

Now you committed your code and you didn't check if it affects some of your components. Now from our controller, we still have the query who relies on `email` field, you've accidentally deployed your code from the live/production website, now that's the problem...

To eliminate this kind of process, while your project is still small, we suggests to apply a unit testing upon adding a new feature in your code.


---


<a name="the-tool"></a>
# The Tool

Have you heard about PHPUnit, Behat, PHPSpec, Codeception? Great! Basically, we can't push all those testing tools on our project. However, we initially added PHPUnit as it is more minimal and the most/majority to use of them all.

In your project folder, there is a folder `tests` which will be your testing folder, you must have a `phpunit.xml` where in the settings lives in it.

By default, all the test classes must have a suffix `Test.php`, for example we can rename `ControllersTest.php`. The default function must have prefix `test`, something like `testUserLogin()`, `testTheUserLists()` and etc.

run this to your console pointing to root project:
```shell
./vendor/bin/phpunit
```

or:

```shell
./vendor/bin/phpunit -c ./phpunit.xml
```

Try to explore more by reading the [PHPUnit documentation](https://phpunit.de/manual/current/en/index.html)
