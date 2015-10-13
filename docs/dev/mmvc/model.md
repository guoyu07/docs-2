MVC can be metaphorically related to a TV. **You have various channels, with different information on them supplied by your cable provider (the model)**. The TV screen displays these channels to you (the view). You pressing the buttons on the remote controls affects what you see and how you see it (the controller). -<a href="http://stackoverflow.com/questions/2626803/mvc-model-view-controller-can-it-be-explained-in-simple-terms#answer-2626813">Tilo Mitra</a>

The model acts as relational mapper for SQL.

## Index:
- [Generate a Model](#generate)
- [Learn More](#learn-more)

# <a href="#generate" name="generate">Generate a Model</a>

```php
php brood make:model TicketLog
> Crafting Model...
>    Model has been created!
```

The above code will generate a file containing a class that acts as our model, located at `{project-root}/components/Model/TicketLog.php`.

```php
namespace Components\Model;

use Components\Model\Traits\Timestampable;
use Components\Model\Traits\SoftDeletable;

class TicketLog extends Model
{
    use Timestampable;
    use SoftDeletable;

    public function getSource()
    {
        return 'ticket_logs';
    }
}
```

We have the function `getSource()`, which refers to the table name in our database.

The above class of code, we're using `Timestampable` and `SoftDeletable` traits which holds an events.

The `Timestampable` holds the `created_at` and `updated_at`, when the event adding or updating a record, it will automatically change their values as timestamp format.

The `SoftDeletable` holds the `deleted_at` column of your table, when the event deleting a record, it also automatically change their values as timestamp format.

# <a href="#learn-more" name="learn-more">Learn More</a>

To learn more, you can fully review the whole models documentation, we also linked the PHQL language that refers to Phalcon Query Language.

- <a target="_blank" href="https://docs.phalconphp.com/en/latest/reference/models.html">https://docs.phalconphp.com/en/latest/reference/models.html</a>
- <a target="_blank" href="https://docs.phalconphp.com/en/latest/reference/phql.html">https://docs.phalconphp.com/en/latest/reference/phql.html</a>
