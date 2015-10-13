The collection acts as a document mapper for NoSQL.

## Index:
- [Configuration](#configuration)
- [Generate a Collection](#generate)
- [Learn More](#learn-more)

<a name="configuration"></a>
# Configuration

This component relies on `config/database.php` under `nosql_adapters` key

```php
'nosql_adapters' => [

        'mongo1' => [
            'host'     => 'localhost',
            'port'     => '27017',
            'username' => '',
            'password' => '',
            'dbname'   => 'mongo1',
        ],
    ],
```

Currently, phalcon only supports MongoDB.

---

<a name="generate"></a>
# Generate a Collection

```php
php brood make:collection TicketLogs
> Crafting Collection...
>    Collection has been created!
```

The above code will generate a file containing a class that acts as our collection model, located at `{project-root}/components/Collection/TicketLogs.php`.

---


<a name="learn-more"></a>
# Learn More

To learn more, you can fully review the whole collection

- <a target="_blank" href="https://docs.phalconphp.com/en/latest/reference/odm.html">https://docs.phalconphp.com/en/latest/reference/odm.html</a>
