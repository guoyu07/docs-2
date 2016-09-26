Building a package would really take time, so we have this sandbox folder that you could work on, for you to be more productive.

# Basic Usage

To generate a new sandbox, run this command.

```php
php brood vendor:new
```

Once you were able to execute the above command, it will ask you about the vendor's name, it is like running a `composer init` via brood console.

So, lets make the name as `acme/product` and `ProductServiceProvider` will be generated at the `{project-root}/sandbox/acme/product`.

The `composer.json` must also be modified, preinserted a key on `repositories` pointing to this path.

The last thing you should run is to execute the `composer update`. This is to reload your working project going to vendor. Your composer will automatically apply a symlink.

To verify, check the `vendor` folder if the folder `acme/product` exists with symlink on it.

```php
ls -l vendor/acme/product
```

You can also check the file `vendor/composer/autoload_psr4.php` if the namespace itself were generated and included too.