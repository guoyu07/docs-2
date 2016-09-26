Here you can follow our coding style before you commit.

# Index
- Snake Case and Why?
  - Variable
  - Native Function
- Comment Blocks

# Snake Case and Why?

We're using `$snake_case` for variables and native functions, for deeper understanding, please check the sample code below.

### Variable

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

### Native Function

```php
if (!function_exists('base_path'))
{
    function base_path($extended_path)
    {
        // code...
    }
}

```

The rest, we follow the PSR standards, make your code self explanatory, even without using any docblock, we should be able to understand it as is.

---


# Comment Blocks

We find using `#` for adding user comments is more readable, and `//` for unused code comment which automatically an eye catching that it is an unused code.

We should only use `/** doc block **/` for class functions and properties/native functions.

For deeper understanding, please check below code for more.

@TODO
