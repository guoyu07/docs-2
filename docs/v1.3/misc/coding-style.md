Hey Yow! here you can follow our coding style before you commit.

We follow PSR-2 and PSR-4 coding standards. Although, we're using `$snake_case` for variables and native functions

### Variable Style

```php
namespace Popeye;

use Clarity\Support\Parser;

class Result
{
      private $results_page;

      public function getResultsPage()
      {
           return $this->results_page;
      }
}

```

### Native Style Functions

```php
if (!function_exists('base_path'))
{
    function base_path($extended_path)
    {
        // code...
    }
}

```

The rest follow the PSR standards, make your code self explanatory, without using any docblock, we should be able to understand it as is.

---


# Comment Blocks

We are using `#` for adding user comments, and `//` for unused code comment.
We should only use `/** doc block **/` for class/class-functions/native-functions.
