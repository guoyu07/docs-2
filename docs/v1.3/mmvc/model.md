MVC can be metaphorically related to a TV. **You have various channels, with different information on them supplied by your cable provider (the model)**. The TV screen displays these channels to you (the view). You pressing the buttons on the remote controls affects what you see and how you see it (the controller). -<a href="http://stackoverflow.com/questions/2626803/mvc-model-view-controller-can-it-be-explained-in-simple-terms#answer-2626813">Tilo Mitra</a>

The model acts as relational mapper for SQL.

## Index:
- [Generate a Model](#generate)
- [Learn More](#learn-more)

---

<a name="generate"></a>
# Generate a Model

```php
php brood make:model TicketLogs
> Crafting Model...
>    Model has been created!
```

The above code will generate a file containing a class that acts as our model, located at `project-name/components/Model/TicketLogs.php`.

```php
namespace Components\Model;

use Components\Model\Traits\Timestampable;
use Components\Model\Traits\SoftDeletable;

class TicketLogs extends Model
{
    use Timestampable;
    use SoftDeletable;

    public function getSource()
    {
        return 'ticketlogs';
    }
}
```

We have the function `getSource()`, which refers to the table name in our database.

The above class of code, we're using **Timestampable** and **SoftDeletable** traits which holds an events.

The **Timestampable** holds the ***created_at*** and ***updated_at***, when we'll be adding or updating a record, it will automatically logs timestamp format.

The **SoftDeletable** holds the **deleted_at** column of your table, when deleting, it will fill the field.


---

<a name="learn-more"></a>
# Learn More

To learn more, you can fully review the whole models documentation, we also linked the PHQL language that refers to Phalcon Query Language.

- <a target="_blank" href="https://docs.phalconphp.com/en/latest/reference/models.html">https://docs.phalconphp.com/en/latest/reference/models.html</a>
- <a target="_blank" href="https://docs.phalconphp.com/en/latest/reference/phql.html">https://docs.phalconphp.com/en/latest/reference/phql.html</a>
