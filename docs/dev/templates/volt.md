Volt is an ultra-fast and designer friendly templating language written in C for PHP. It provides you a set of helpers to write views in an easy way. Volt is highly integrated with other components of Phalcon, just as you can use it as a stand-alone component in your applications.

Volt is inspired by [Jinja](http://jinja.pocoo.org/), originally created by [Armin Ronacher](https://github.com/mitsuhiko). Therefore many developers will be in familiar territory using the same syntax they have been using with similar template engines. Volt's syntax and features have been enhanced with more elements and of course with the performance that developers have been accustomed to while working with Phalcon.

Introduction
------------

Volt views are compiled to pure PHP code, so basically they save the effort of writing PHP code manually:

~~~~ {.sourceCode .html+jinja}
{# app/views/products/show.volt #}

{% block last_products %}

{% for product in products %}
    * Name: {{ product.name|e }}
    {% if product.status == "Active" %}
       Price: {{ product.price + product.taxes/100 }}
    {% endif  %}
{% endfor  %}

{% endblock %}
~~~~

Basic Usage
-----------

A view consists of Volt code, PHP and HTML. A set of special delimiters is available to enter into Volt mode. `{% ... %}` is used to execute statements such as for-loops or assign values, while `{{ ... }}` prints the result of an expression to the template.

Below is a minimal template that illustrates a few basics:

~~~~ {.sourceCode .html+jinja}
{# app/views/posts/show.phtml #}
<!DOCTYPE html>
<html>
    <head>
        <title>{{ title }} - An example blog</title>
    </head>
    <body>

        {% if show_navigation %}
            <ul id="navigation">
                {% for item in menu %}
                    <li>
                        <a href="{{ item.href }}">
                            {{ item.caption }}
                        </a>
                    </li>
                {% endfor %}
            </ul>
        {% endif %}

        <h1>{{ post.title }}</h1>

        <div class="content">
            {{ post.content }}
        </div>

    </body>
</html>
~~~~

Using `Phalcon\\Mvc\\View` you can pass variables from the controller to the views. In the above example, three variables were passed to the view and they are the `title`, `menu` and `post`.

~~~~ {.sourceCode .php}
<?php

namespace App\Blog\Controllers;

use Components\Model\Post;
use Components\Model\Menu;

class PostsController extends Controller
{
    public function show()
    {
        $post = Post::findFirst();
        $menu = Menu::findFirst();

        view()->title = $post->title;
        view()->post = $post;
        view()->menu = $menu;
        view()->show_navigation = true;

        # or ...

        view()->setVar("title", $post->title);
        view()->setVar("post", $post);
        view()->setVar("menu", $menu);
        view()->setVar("show_navigation", true);
    }
}
~~~~

Variables
---------

Object variables may have attributes which can be accessed using the syntax `foo.bar`. If you are passing arrays, you have to use the square bracket syntax such as `foo['bar']`

~~~~ {.sourceCode .jinja}
{{ post.title }} {# for $post->title #}
{{ post['title'] }} {# for $post['title'] #}
~~~~

Filters
-------

Variables can be formatted or modified using filters. The pipe operator `|` is used to apply filters to variables.

~~~~ {.sourceCode .jinja}
{{ post.title|e }}
{{ post.content|striptags }}
{{ name|capitalize|trim }}
~~~~

The following is the lists of all available built-in filters in Volt.

<table>
  <col width="25%" />
  <col width="74%" />
  <thead>
    <tr class="header">
      <th align="left">Filter</th>
      <th align="left">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">e</td>
      <td align="left">Applies Phalcon\Escaper-&gt;escapeHtml() to the value</td>
    </tr>
    <tr class="even">
      <td align="left">escape</td>
      <td align="left">Applies Phalcon\Escaper-&gt;escapeHtml() to the value</td>
    </tr>
    <tr class="odd">
      <td align="left">escape_css</td>
      <td align="left">Applies Phalcon\Escaper-&gt;escapeCss() to the value</td>
    </tr>
    <tr class="even">
      <td align="left">escape_js</td>
      <td align="left">Applies Phalcon\Escaper-&gt;escapeJs() to the value</td>
    </tr>
    <tr class="odd">
      <td align="left">escape_attr</td>
      <td align="left">Applies Phalcon\Escaper-&gt;escapeHtmlAttr() to the value</td>
    </tr>
    <tr class="even">
      <td align="left">trim</td>
      <td align="left">Applies the <a href="http://php.net/manual/en/function.trim.php">trim</a> PHP function to the value. Removing extra spaces</td>
    </tr>
    <tr class="odd">
      <td align="left">left_trim</td>
      <td align="left">Applies the <a href="http://php.net/manual/en/function.ltrim.php">ltrim</a> PHP function to the value. Removing extra spaces</td>
    </tr>
    <tr class="even">
      <td align="left">right_trim</td>
      <td align="left">Applies the <a href="http://php.net/manual/en/function.rtrim.php">rtrim</a> PHP function to the value. Removing extra spaces</td>
    </tr>
    <tr class="odd">
      <td align="left">striptags</td>
      <td align="left">Applies the <a href="http://php.net/manual/en/function.striptags.php">striptags</a> PHP function to the value. Removing HTML tags</td>
    </tr>
    <tr class="even">
      <td align="left">slashes</td>
      <td align="left">Applies the <a href="http://php.net/manual/en/function.slashes.php">slashes</a> PHP function to the value. Escaping values</td>
    </tr>
    <tr class="odd">
      <td align="left">stripslashes</td>
      <td align="left">Applies the <a href="http://php.net/manual/en/function.stripslashes.php">stripslashes</a> PHP function to the value. Removing escaped quotes</td>
    </tr>
    <tr class="even">
      <td align="left">capitalize</td>
      <td align="left">Capitalizes a string by applying the <a href="http://php.net/manual/en/function.ucwords.php">ucwords</a> PHP function to the value</td>
    </tr>
    <tr class="odd">
      <td align="left">lower</td>
      <td align="left">Change the case of a string to lowercase</td>
    </tr>
    <tr class="even">
      <td align="left">upper</td>
      <td align="left">Change the case of a string to uppercase</td>
    </tr>
    <tr class="odd">
      <td align="left">length</td>
      <td align="left">Counts the string length or how many items are in an array or object</td>
    </tr>
    <tr class="even">
      <td align="left">nl2br</td>
      <td align="left">Changes newlines \n by line breaks (&lt;br /&gt;). Uses the PHP function <a href="http://php.net/manual/en/function.nl2br.php">nl2br</a>
      </td>
    </tr>
    <tr class="odd">
      <td align="left">sort</td>
      <td align="left">Sorts an array using the PHP function <a href="http://php.net/manual/en/function.asort.php">asort</a>
      </td>
    </tr>
    <tr class="even">
      <td align="left">keys</td>
      <td align="left">Returns the array keys using <a href="http://php.net/manual/en/function.array-keys.php">arraykkeys</a>
      </td>
    </tr>
    <tr class="odd">
      <td align="left">join</td>
      <td align="left">Joins the array parts using a separator <a href="http://php.net/manual/en/function.join.php">join</a>
      </td>
    </tr>
    <tr class="even">
      <td align="left">format</td>
      <td align="left">Formats a string using <a href="http://php.net/manual/en/function.sprintf.php">sprintf</a>.</td>
    </tr>
    <tr class="odd">
      <td align="left">json_encode</td>
      <td align="left">Converts a value into its <a href="http://php.net/manual/en/function.json-encode.php">JSON</a> representation</td>
    </tr>
    <tr class="even">
      <td align="left">json_decode</td>
      <td align="left">Converts a value from its <a href="http://php.net/manual/en/function.json-encode.php">JSON</a> representation to a PHP representation</td>
    </tr>
    <tr class="odd">
      <td align="left">abs</td>
      <td align="left">Applies the <a href="http://php.net/manual/en/function.abs.php">abs</a> PHP function to a value.</td>
    </tr>
    <tr class="even">
      <td align="left">url_encode</td>
      <td align="left">Applies the <a href="http://php.net/manual/en/function.urlencode.php">urlencode</a> PHP function to the value</td>
    </tr>
    <tr class="odd">
      <td align="left">default</td>
      <td align="left">Sets a default value in case that the evaluated expression is empty (is not set or evaluates to a falsy value)</td>
    </tr>
    <tr class="even">
      <td align="left">convert_encoding</td>
      <td align="left">Converts a string from one charset to another</td>
    </tr>
  </tbody>
</table>

Examples:

~~~~ {.sourceCode .jinja}
{# e or escape filter #}
{{ "<h1>Hello<h1>"|e }}
{{ "<h1>Hello<h1>"|escape }}

{# trim filter #}
{{ "   hello   "|trim }}

{# striptags filter #}
{{ "<h1>Hello<h1>"|striptags }}

{# slashes filter #}
{{ "'this is a string'"|slashes }}

{# stripslashes filter #}
{{ "\'this is a string\'"|stripslashes }}

{# capitalize filter #}
{{ "hello"|capitalize }}

{# lower filter #}
{{ "HELLO"|lower }}

{# upper filter #}
{{ "hello"|upper }}

{# length filter #}
{{ "robots"|length }}
{{ [1, 2, 3]|length }}

{# nl2br filter #}
{{ "some\ntext"|nl2br }}

{# sort filter #}
{% set sorted = [3, 1, 2]|sort %}

{# keys filter #}
{% set keys = ['first': 1, 'second': 2, 'third': 3]|keys %}

{# join filter #}
{% set joined = "a".."z"|join(",") %}

{# format filter #}
{{ "My real name is %s"|format(name) }}

{# json_encode filter #}
{% set encoded = robots|json_encode %}

{# json_decode filter #}
{% set decoded = '{"one":1,"two":2,"three":3}'|json_decode %}

{# url_encode filter #}
{{ post.permanent_link|url_encode }}

{# convert_encoding filter #}
{{ "désolé"|convert_encoding('utf8', 'latin1') }}
~~~~

Comments
--------

Comments may also be added to a template using the `{# ... #}` delimiters. All text inside them is just ignored in the final output:

~~~~ {.sourceCode .jinja}
{# note: this is a comment
    {% set price = 100; %}
#}
~~~~

List of Control Structures
--------------------------

Volt provides a set of basic but powerful control structures for use in templates:

### For

Loop over each item in a sequence. The following example shows how to traverse a set of `robots` and print the name.

~~~~ {.sourceCode .html+jinja}
<h1>Robots</h1>
<ul>
    {% for robot in robots %}
        <li>
            {{ robot.name|e }}
        </li>
    {% endfor %}
</ul>
~~~~

for-loops can also be nested.

~~~~ {.sourceCode .html+jinja}
<h1>Robots</h1>
{% for robot in robots %}
    {% for part in robot.parts %}
        Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
    {% endfor %}
{% endfor %}
~~~~

You can get the element `keys` as in the PHP counterpart using the following syntax.

~~~~ {.sourceCode .html+jinja}
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for name, value in numbers %}
    Name: {{ name }} Value: {{ value }}
{% endfor %}
~~~~

An `if` evaluation can be optionally set.

~~~~ {.sourceCode .html+jinja}
{% set numbers = ['one': 1, 'two': 2, 'three': 3] %}

{% for value in numbers if value < 2 %}
    Value: {{ value }}
{% endfor %}

{% for name, value in numbers if name != 'two' %}
    Name: {{ name }} Value: {{ value }}
{% endfor %}
~~~~

If an `else` is defined inside the `for`, it will be executed if the expression in the iterator result in zero iterations:

~~~~ {.sourceCode .html+jinja}
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
{% else %}
    There are no robots to show
{% endfor %}
~~~~

Alternative syntax.

~~~~ {.sourceCode .html+jinja}
<h1>Robots</h1>
{% for robot in robots %}
    Robot: {{ robot.name|e }} Part: {{ part.name|e }} <br />
{% elsefor %}
    There are no robots to show
{% endfor %}
~~~~

### Loop Controls

The `break` and `continue` statements can be used to exit from a loop or force an iteration in the current block.

~~~~ {.sourceCode .html+jinja}
{# skip the even robots #}
{% for index, robot in robots %}
    {% if index is even %}
        {% continue %}
    {% endif %}
    ...
{% endfor %}
~~~~

~~~~ {.sourceCode .html+jinja}
{# exit the foreach on the first even robot #}
{% for index, robot in robots %}
    {% if index is even %}
        {% break %}
    {% endif %}
    ...
{% endfor %}
~~~~

### If

As PHP, an `if` statement checks if an expression is evaluated as `true` or `false`,

~~~~ {.sourceCode .html+jinja}
<h1>Cyborg Robots</h1>
<ul>
    {% for robot in robots %}
        {% if robot.type == "cyborg" %}
            <li>{{ robot.name|e }}</li>
        {% endif %}
    {% endfor %}
</ul>
~~~~

The `else` clause is also supported.

~~~~ {.sourceCode .html+jinja}
<h1>Robots</h1>
<ul>
    {% for robot in robots %}
        {% if robot.type == "cyborg" %}
            <li>{{ robot.name|e }}</li>
        {% else %}
            <li>{{ robot.name|e }} (not a cyborg)</li>
        {% endif %}
    {% endfor %}
</ul>
~~~~

The `elseif` control flow structure can be used together with if to emulate a `switch` block.

~~~~ {.sourceCode .html+jinja}
{% if robot.type == "cyborg" %}
    Robot is a cyborg
{% elseif robot.type == "virtual" %}
    Robot is virtual
{% elseif robot.type == "mechanical" %}
    Robot is mechanical
{% endif %}
~~~~

### Loop Context

A special variable is available inside `for` loops providing you information about.

<table>
  <col width="28%" />
  <col width="71%" />
  <thead>
    <tr class="header">
      <th align="left">Variable</th>
      <th align="left">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">loop.index</td>
      <td align="left">The current iteration of the loop. (1 indexed)</td>
    </tr>
    <tr class="even">
      <td align="left">loop.index0</td>
      <td align="left">The current iteration of the loop. (0 indexed)</td>
    </tr>
    <tr class="odd">
      <td align="left">loop.revindex</td>
      <td align="left">The number of iterations from the end of the loop (1 indexed)</td>
    </tr>
    <tr class="even">
      <td align="left">loop.revindex0</td>
      <td align="left">The number of iterations from the end of the loop (0 indexed)</td>
    </tr>
    <tr class="odd">
      <td align="left">loop.first</td>
      <td align="left">True if in the first iteration.</td>
    </tr>
    <tr class="even">
      <td align="left">loop.last</td>
      <td align="left">True if in the last iteration.</td>
    </tr>
    <tr class="odd">
      <td align="left">loop.length</td>
      <td align="left">The number of items to iterate</td>
    </tr>
  </tbody>
</table>

~~~~ {.sourceCode .html+jinja}
{% for robot in robots %}
    {% if loop.first %}
        <table>
            <tr>
                <th>#</th>
                <th>Id</th>
                <th>Name</th>
            </tr>
    {% endif %}
            <tr>
                <td>{{ loop.index }}</td>
                <td>{{ robot.id }}</td>
                <td>{{ robot.name }}</td>
            </tr>
    {% if loop.last %}
        </table>
    {% endif %}
{% endfor %}
~~~~

Assignments
-----------

Variables may be changed in a template using the instruction `set`.

~~~~ {.sourceCode .html+jinja}
{% set fruits = ['Apple', 'Banana', 'Orange'] %}

{% set name = robot.name %}
~~~~

Multiple assignments are allowed in the same instruction.

~~~~ {.sourceCode .html+jinja}
{% set fruits = ['Apple', 'Banana', 'Orange'], name = robot.name, active = true %}
~~~~

Additionally, you can use compound assignment operators:

~~~~ {.sourceCode .html+jinja}
{% set price += 100.00 %}

{% set age *= 5 %}
~~~~

The following operators are available.

<table>
  <col width="22%" />
  <col width="77%" />
  <thead>
    <tr class="header">
      <th align="left">Operator</th>
      <th align="left">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">=</td>
      <td align="left">Standard Assignment</td>
    </tr>
    <tr class="even">
      <td align="left">+=</td>
      <td align="left">Addition assignment</td>
    </tr>
    <tr class="odd">
      <td align="left">-=</td>
      <td align="left">Subtraction assignment</td>
    </tr>
    <tr class="even">
      <td align="left">*=</td>
      <td align="left">Multiplication assignment</td>
    </tr>
    <tr class="odd">
      <td align="left">/=</td>
      <td align="left">Division assignment</td>
    </tr>
  </tbody>
</table>

Expressions
-----------

Volt provides a basic set of expression support, including literals and common operators.

A expression can be evaluated and printed using the `{{` and `}}` delimiters.

~~~~ {.sourceCode .html+jinja}
{{ (1 + 1) * 2 }}
~~~~

If an expression needs to be evaluated without be printed the `do` statement can be used.

~~~~ {.sourceCode .html+jinja}
{% do (1 + 1) * 2 %}
~~~~

### Literals

The following literals are supported.

<table>
  <col width="22%" />
  <col width="77%" />
  <thead>
    <tr class="header">
      <th align="left">Filter</th>
      <th align="left">Description</th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">&quot;this is a string&quot;</td>
      <td align="left">Text between double quotes or single quotes are handled as strings</td>
    </tr>
    <tr class="even">
      <td align="left">100.25</td>
      <td align="left">Numbers with a decimal part are handled as doubles/floats</td>
    </tr>
    <tr class="odd">
      <td align="left">100</td>
      <td align="left">Numbers without a decimal part are handled as integers</td>
    </tr>
    <tr class="even">
      <td align="left">false</td>
      <td align="left">Constant &quot;false&quot; is the boolean false value</td>
    </tr>
    <tr class="odd">
      <td align="left">true</td>
      <td align="left">Constant &quot;true&quot; is the boolean true value</td>
    </tr>
    <tr class="even">
      <td align="left">null</td>
      <td align="left">Constant &quot;null&quot; is the Null value</td>
    </tr>
  </tbody>
</table>

### Arrays

Whether you're using PHP 5.3 or \>= 5.4 you can create arrays by enclosing a list of values in square brackets.

~~~~ {.sourceCode .html+jinja}
{# Simple array #}
{{ ['Apple', 'Banana', 'Orange'] }}

{# Other simple array #}
{{ ['Apple', 1, 2.5, false, null] }}

{# Multi-Dimensional array #}
{{ [[1, 2], [3, 4], [5, 6]] }}

{# Hash-style array #}
{{ ['first': 1, 'second': 4/2, 'third': '3'] }}
~~~~

Curly braces also can be used to define arrays or hashes.

~~~~ {.sourceCode .html+jinja}
{% set myArray = {'Apple', 'Banana', 'Orange'} %}
{% set myHash  = {'first': 1, 'second': 4/2, 'third': '3'} %}
~~~~

### Math

You may make calculations in templates using the following operators.m, n

<table>
  <col width="13%">
  <col width="86%">
  <thead>
    <tr class="header">
      <th align="left">
        Operator
      </th>
      <th align="left">
        Description
      </th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">
        +
      </td>
      <td align="left">
        Perform an adding operation. {{ 2 + 3 }} returns 5
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        -
      </td>
      <td align="left">
        Perform a substraction operation {{ 2 - 3 }} returns -1
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        *
      </td>
      <td align="left">
        Perform a multiplication operation {{ 2 * 3 }} returns 6
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        /
      </td>
      <td align="left">
        Perform a division operation {{ 10 / 2 }} returns 5
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        %
      </td>
      <td align="left">
        Calculate the remainder of an integer division {{ 10 % 3 }} returns 1
      </td>
    </tr>
  </tbody>
</table>

### Comparisons

The following comparison operators are available.

<table>
  <col width="17%">
  <col width="82%">
  <thead>
    <tr class="header">
      <th align="left">
        Operator
      </th>
      <th align="left">
        Description
      </th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">
        ==
      </td>
      <td align="left">
        Check whether both operands are equal
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        !=
      </td>
      <td align="left">
        Check whether both operands aren't equal
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        &lt;&gt;
      </td>
      <td align="left">
        Check whether both operands aren't equal
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        &gt;
      </td>
      <td align="left">
        Check whether left operand is greater than right operand
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        &lt;
      </td>
      <td align="left">
        Check whether left operand is less than right operand
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        &lt;=
      </td>
      <td align="left">
        Check whether left operand is less or equal than right operand
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        &gt;=
      </td>
      <td align="left">
        Check whether left operand is greater or equal than right operand
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        ===
      </td>
      <td align="left">
        Check whether both operands are identical
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        !==
      </td>
      <td align="left">
        Check whether both operands aren't identical
      </td>
    </tr>
  </tbody>
</table>

### Logic

Logic operators are useful in the `if` expression evaluation to combine multiple tests.

<table>
  <col width="21%">
  <col width="78%">
  <thead>
    <tr class="header">
      <th align="left">
        Operator
      </th>
      <th align="left">
        Description
      </th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">
        or
      </td>
      <td align="left">
        Return true if the left or right operand is evaluated as true
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        and
      </td>
      <td align="left">
        Return true if both left and right operands are evaluated as true
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        not
      </td>
      <td align="left">
        Negates an expression
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        ( expr )
      </td>
      <td align="left">
        Parenthesis groups expressions
      </td>
    </tr>
  </tbody>
</table>

### Other Operators

Additional operators seen the following operators are available.

<table>
  <col width="22%">
  <col width="77%">
  <thead>
    <tr class="header">
      <th align="left">
        Operator
      </th>
      <th align="left">
        Description
      </th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">
        ~
      </td>
      <td align="left">
        Concatenates both operands {{ &quot;hello &quot; ~ &quot;world&quot; }}
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        |
      </td>
      <td align="left">
        Applies a filter in the right operand to the left {{ &quot;hello&quot;|uppercase }}
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        ..
      </td>
      <td align="left">
        Creates a range {{ 'a'..'z' }} {{ 1..10 }}
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        is
      </td>
      <td align="left">
        Same as == (equals), also performs tests
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        in
      </td>
      <td align="left">
        To check if an expression is contained into other expressions if &quot;a&quot; in &quot;abc&quot;
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        is not
      </td>
      <td align="left">
        Same as != (not equals)
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        'a' ? 'b' : 'c'
      </td>
      <td align="left">
        Ternary operator. The same as the PHP ternary operator
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        ++
      </td>
      <td align="left">
        Increments a value
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        --
      </td>
      <td align="left">
        Decrements a value
      </td>
    </tr>
  </tbody>
</table>

The following example shows how to use operators.

~~~~ {.sourceCode .html+jinja}
{% set robots = ['Voltron', 'Astro Boy', 'Terminator', 'C3PO'] %}

{% for index in 0..robots|length %}
    {% if robots[index] is defined %}
        {{ "Name: " ~ robots[index] }}
    {% endif %}
{% endfor %}
~~~~

Tests
-----

Tests can be used to test if a variable has a valid expected value. The operator `is` is used to perform the tests.

~~~~ {.sourceCode .html+jinja}
{% set robots = ['1': 'Voltron', '2': 'Astro Boy', '3': 'Terminator', '4': 'C3PO'] %}

{% for position, name in robots %}
    {% if position is odd %}
        {{ name }}
    {% endif %}
{% endfor %}
~~~~

The following built-in tests are available in Volt.
<table>
  <col width="23%">
  <col width="76%">
  <thead>
    <tr class="header">
      <th align="left">
        Test
      </th>
      <th align="left">
        Description
      </th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">
        defined
      </td>
      <td align="left">
        Checks if a variable is defined (isset())
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        empty
      </td>
      <td align="left">
        Checks if a variable is empty
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        even
      </td>
      <td align="left">
        Checks if a numeric value is even
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        odd
      </td>
      <td align="left">
        Checks if a numeric value is odd
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        numeric
      </td>
      <td align="left">
        Checks if value is numeric
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        scalar
      </td>
      <td align="left">
        Checks if value is scalar (not an array or object)
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        iterable
      </td>
      <td align="left">
        Checks if a value is iterable. Can be traversed by a &quot;for&quot; statement
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        divisibleby
      </td>
      <td align="left">
        Checks if a value is divisible by other value
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        sameas
      </td>
      <td align="left">
        Checks if a value is identical to other value
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        type
      </td>
      <td align="left">
        Checks if a value is of the specified type
      </td>
    </tr>
  </tbody>
</table>

More examples.

~~~~ {.sourceCode .html+jinja}
{% if robot is defined %}
    The robot variable is defined
{% endif %}

{% if robot is empty %}
    The robot is null or isn't defined
{% endif %}

{% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 3: 'Bender'] %}
    {% if key is even %}
        {{ name }}
    {% endif %}
{% endfor %}

{% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 3: 'Bender'] %}
    {% if key is odd %}
        {{ name }}
    {% endif %}
{% endfor %}

{% for key, name in [1: 'Voltron', 2: 'Astroy Boy', 'third': 'Bender'] %}
    {% if key is numeric %}
        {{ name }}
    {% endif %}
{% endfor %}

{% set robots = [1: 'Voltron', 2: 'Astroy Boy'] %}
{% if robots is iterable %}
    {% for robot in robots %}
        ...
    {% endfor %}
{% endif %}

{% set world = "hello" %}
{% if world is sameas("hello") %}
    {{ "it's hello" }}
{% endif %}

{% set external = false %}
{% if external is type('boolean') %}
    {{ "external is false or true" }}
{% endif %}
~~~~

Macros
------

Macros can be used to reuse logic in a template, they act as PHP functions, can receive parameters and return values:

~~~~ {.sourceCode .html+jinja}
{# Macro "display a list of links to related topics" #}
{%- macro related_bar(related_links) %}
    <ul>
        {%- for link in related_links %}
            <li>
                <a href="{{ url(link.url) }}" title="{{ link.title|striptags }}">
                    {{ link.text }}
                </a>
            </li>
        {%- endfor %}
    </ul>
{%- endmacro %}

{# Print related links #}
{{ related_bar(links) }}

<div>This is the content</div>

{# Print related links again #}
{{ related_bar(links) }}
~~~~

When calling macros, parameters can be passed by name.

~~~~ {.sourceCode .html+jinja}
{%- macro error_messages(message, field, type) %}
    <div>
        <span class="error-type">{{ type }}</span>
        <span class="error-field">{{ field }}</span>
        <span class="error-message">{{ message }}</span>
    </div>
{%- endmacro %}

{# Call the macro #}
{{ error_messages('type': 'Invalid', 'message': 'The name is invalid', 'field': 'name') }}
~~~~

Macros can return values.

~~~~ {.sourceCode .html+jinja}
{%- macro my_input(name, class) %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
~~~~

And receive optional parameters.

~~~~ {.sourceCode .html+jinja}
{%- macro my_input(name, class="input-text") %}
    {% return text_field(name, 'class': class) %}
{%- endmacro %}

{# Call the macro #}
{{ '<p>' ~ my_input('name') ~ '</p>' }}
{{ '<p>' ~ my_input('name', 'input-text') ~ '</p>' }}
~~~~

Using Tag Helpers
-----------------

Volt is highly integrated with Phalcon\\\\Tag \<tags\>, so it's easy to use the helpers provided by that component in a Volt template:

~~~~ {.sourceCode .html+jinja}
{{ javascript_include("js/jquery.js") }}

{{ form('products/save', 'method': 'post') }}

    <label for="name">Name</label>
    {{ text_field("name", "size": 32) }}

    <label for="type">Type</label>
    {{ select("type", productTypes, 'using': ['id', 'name']) }}

    {{ submit_button('Send') }}

{{ end_form() }}
~~~~

The following PHP is generated.

~~~~ {.sourceCode .html+php}
<?php echo Phalcon\Tag::javascriptInclude("js/jquery.js") ?>

<?php echo Phalcon\Tag::form(array('products/save', 'method' => 'post')); ?>

    <label for="name">Name</label>
    <?php echo Phalcon\Tag::textField(array('name', 'size' => 32)); ?>

    <label for="type">Type</label>
    <?php echo Phalcon\Tag::select(array('type', $productTypes, 'using' => array('id', 'name'))); ?>

    <?php echo Phalcon\Tag::submitButton('Send'); ?>

{{ end_form() }}
~~~~

To call a Phalcon\\Tag helper, you only need to call an uncamelized version of the method.
<table>
  <col width="57%">
  <col width="40%">
  <thead>
    <tr class="header">
      <th align="left">
        Method
      </th>
      <th align="left">
        Volt function
      </th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::linkTo
      </td>
      <td align="left">
        link_to
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::textField
      </td>
      <td align="left">
        text_field
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::passwordField
      </td>
      <td align="left">
        password_field
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::hiddenField
      </td>
      <td align="left">
        hidden_field
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::fileField
      </td>
      <td align="left">
        file_field
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::checkField
      </td>
      <td align="left">
        check_field
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::radioField
      </td>
      <td align="left">
        radio_field
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::dateField
      </td>
      <td align="left">
        date_field
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::emailField
      </td>
      <td align="left">
        email_field
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::numericField
      </td>
      <td align="left">
        numeric_field
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::submitButton
      </td>
      <td align="left">
        submit_button
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::selectStatic
      </td>
      <td align="left">
        select_static
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::select
      </td>
      <td align="left">
        select
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::textArea
      </td>
      <td align="left">
        text_area
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::form
      </td>
      <td align="left">
        form
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::endForm
      </td>
      <td align="left">
        end_form
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::getTitle
      </td>
      <td align="left">
        get_title
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::stylesheetLink
      </td>
      <td align="left">
        stylesheet_link
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::javascriptInclude
      </td>
      <td align="left">
        javascript_include
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        Phalcon\Tag::image
      </td>
      <td align="left">
        image
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        Phalcon\Tag::friendlyTitle
      </td>
      <td align="left">
        friendly_title
      </td>
    </tr>
  </tbody>
</table>

Functions
---------

The following built-in functions are available in Volt.

<table>
  <col width="26%">
  <col width="73%">
  <thead>
    <tr class="header">
      <th align="left">
        Name
      </th>
      <th align="left">
        Description
      </th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td align="left">
        content
      </td>
      <td align="left">
        Includes the content produced in a previous rendering stage
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        get_content
      </td>
      <td align="left">
        Same as content
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        partial
      </td>
      <td align="left">
        Dynamically loads a partial view in the current template
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        super
      </td>
      <td align="left">
        Render the contents of the parent block
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        time
      </td>
      <td align="left">
        Calls the PHP function with the same name
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        date
      </td>
      <td align="left">
        Calls the PHP function with the same name
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        dump
      </td>
      <td align="left">
        Calls the PHP function var_dump()
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        version
      </td>
      <td align="left">
        Returns the current version of the framework
      </td>
    </tr>
    <tr class="odd">
      <td align="left">
        constant
      </td>
      <td align="left">
        Reads a PHP constant
      </td>
    </tr>
    <tr class="even">
      <td align="left">
        url
      </td>
      <td align="left">
        Generate a URL using the 'url' service
      </td>
    </tr>
  </tbody>
</table>

View Integration
----------------

Also, Volt is integrated with Phalcon\\Mvc\\View, you can play with the view hierarchy and include partials as well.

~~~~ {.sourceCode .html+jinja}
{{ content() }}

<!-- Simple include of a partial -->
<div id="footer">{{ partial("partials/footer") }}</div>

<!-- Passing extra variables -->
<div id="footer">{{ partial("partials/footer", ['links': links]) }}</div>
~~~~

A partial is included in runtime, Volt also provides `include`, this compiles the content of a view and returns its contents as part of the view which was included.

~~~~ {.sourceCode .html+jinja}
{# Simple include of a partial #}
<div id="footer">
    {% include "partials/footer" %}
</div>

{# Passing extra variables #}
<div id="footer">
    {% include "partials/footer" with ['links': links] %}
</div>
~~~~

### Include

`include` has a special behavior that will help us improve performance a bit when using Volt, if you specify the extension when including the file and it exists when the template is compiled, Volt can inline the contents of the template in the parent template where it's included. Templates aren't inlined if the `include` have variables passed with `with`.

~~~~ {.sourceCode .html+jinja}
{# The contents of 'partials/footer.volt' is compiled and inlined #}
<div id="footer">
    {% include "partials/footer.volt" %}
</div>
~~~~

### Partial vs Include

Keep the following points in mind when choosing to use the `partial` function or `include`.

-   'Partial' allows you to include templates made in Volt and in other template engines as well
-   'Partial' allows you to pass an expression like a variable allowing to include the content of other view dynamically
-   'Partial' is better if the content that you have to include changes frequently
-   'Include' copies the compiled content into the view which improves the performance
-   'Include' only allows to include templates made with Volt
-   'Include' requires an existing template at compile time

Template Inheritance
--------------------

With template inheritance you can create base templates that can be extended by others templates allowing to reuse code. A base template define *blocks* than can be overridden by a child template. Let's pretend that we have the following base template.

~~~~ {.sourceCode .html+jinja}
{# templates/base.volt #}
<!DOCTYPE html>
<html>
    <head>
        {% block head %}
            <link rel="stylesheet" href="style.css" />
        {% endblock %}

        <title>{% block title %}{% endblock %} - My Webpage</title>
    </head>

    <body>
        <div id="content">{% block content %}{% endblock %}</div>

        <div id="footer">
            {% block footer %}&copy; Copyright 2015, All rights reserved.{% endblock %}
        </div>
    </body>
</html>
~~~~

From other template we could extend the base template replacing the blocks.

~~~~ {.sourceCode .jinja}
{% extends "templates/base.volt" %}

{% block title %}Index{% endblock %}

{% block head %}<style type="text/css">.important { color: #336699; }</style>{% endblock %}

{% block content %}
    <h1>Index</h1>
    <p class="important">Welcome on my awesome homepage.</p>
{% endblock %}
~~~~

Not all blocks must be replaced at a child template, only those that are needed. The final output produced will be the following.

~~~~ {.sourceCode .html}
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">.important { color: #336699; }</style>

        <title>Index - My Webpage</title>
    </head>

    <body>
        <div id="content">
            <h1>Index</h1>
            <p class="important">Welcome on my awesome homepage.</p>
        </div>

        <div id="footer">
            &copy; Copyright 2015, All rights reserved.
        </div>
    </body>
</html>
~~~~

### Multiple Inheritance

Extended templates can extend other templates. The following example illustrates this.

~~~~ {.sourceCode .html+jinja}
{# main.volt #}
<!DOCTYPE html>
<html>
    <head>
        <title>Title</title>
    </head>

    <body>
        {% block content %}{% endblock %}
    </body>
</html>
~~~~

Template `layout.volt` extends `main.volt`

~~~~ {.sourceCode .html+jinja}
{# layout.volt #}
{% extends "main.volt" %}

{% block content %}

    <h1>Table of contents</h1>

{% endblock %}
~~~~

Finally a view that extends "layout.volt":

~~~~ {.sourceCode .html+jinja}
{# index.volt #}
{% extends "layout.volt" %}

{% block content %}

    {{ super() }}

    <ul>
        <li>Some option</li>
        <li>Some other option</li>
    </ul>

{% endblock %}
~~~~

Rendering `index.volt` produces.

~~~~ {.sourceCode .html}
<!DOCTYPE html>
<html>
    <head>
        <title>Title</title>
    </head>

    <body>

        <h1>Table of contents</h1>

        <ul>
            <li>Some option</li>
            <li>Some other option</li>
        </ul>

    </body>
</html>
~~~~

Note the call to the function `super()`. With that function it's possible to render the contents of the parent block.

As partials, the path set to `extends` is a relative path under the current views directory (i.e. resources/views/).

> By default, and for performance reasons, Volt only checks for changes in the children templates to know when to re-compile to plain PHP again, so it is recommended initialize Volt with the option `'compileAlways' =\> true`. Thus, the templates are compiled always taking into account changes in the parent templates.

Autoescape mode
---------------

You can enable auto-escaping of all variables printed in a block using the autoescape mode:

~~~~ {.sourceCode .html+jinja}
Manually escaped: {{ robot.name|e }}

{% autoescape true %}
    Autoescaped: {{ robot.name }}
    {% autoescape false %}
        No Autoescaped: {{ robot.name }}
    {% endautoescape %}
{% endautoescape %}
~~~~

Setting up the Volt Engine
--------------------------

Volt can be configured to alter its default behavior, the following example explain how to do that:

~~~~ {.sourceCode .php}
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

// Register Volt as a service
$di->set(
    "voltService",
    function ($view, $di) {
        $volt = new Volt($view, $di);

        $volt->setOptions(
            [
                "compiledPath"      => "../app/compiled-templates/",
                "compiledExtension" => ".compiled",
            ]
        );

        return $volt;
    }
);

// Register Volt as template engine
$di->set(
    "view",
    function () {
        $view = new View();

        $view->setViewsDir("../app/views/");

        $view->registerEngines(
            [
                ".volt" => "voltService",
            ]
        );

        return $view;
    }
);
~~~~

If you do not want to reuse Volt as a service you can pass an anonymous function to register the engine instead of a service name:

~~~~ {.sourceCode .php}
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

// Register Volt as template engine with an anonymous function
$di->set(
    "view",
    function () {
        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir("../app/views/");

        $view->registerEngines(
            [
                ".volt" => function ($view, $di) {
                    $volt = new Volt($view, $di);

                    // Set some options here

                    return $volt;
                }
            ]
        );

        return $view;
    }
);
~~~~

The following options are available in Volt:

<table>
<col width="16%" />
<col width="76%" />
<col width="60%" />
<thead>
<tr class="header">
<th align="left">Option</th>
<th align="left">Description</th>
<th align="left">Default</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left">compiledPath</td>
<td align="left">A writable path where the compiled PHP templates will be placed</td>
<td align="left">./</td>
</tr>
<tr class="even">
<td align="left">compiledExtension</td>
<td align="left">An additional extension appended to the compiled PHP file</td>
<td align="left">.php</td>
</tr>
<tr class="odd">
<td align="left">compiledSeparator</td>
<td align="left">Volt replaces the directory separators / and \ by this separator in order to create a single file in the compiled directory</td>
<td align="left">%%</td>
</tr>
<tr class="even">
<td align="left">stat</td>
<td align="left">Whether Phalcon must check if exists differences between the template file and its compiled path</td>
<td align="left">true</td>
</tr>
<tr class="odd">
<td align="left">compileAlways</td>
<td align="left">Tell Volt if the templates must be compiled in each request or only when they change</td>
<td align="left">false</td>
</tr>
<tr class="even">
<td align="left">prefix</td>
<td align="left">Allows to prepend a prefix to the templates in the compilation path</td>
<td align="left">null</td>
</tr>
<tr class="odd">
<td align="left">autoescape</td>
<td align="left">Enables globally autoescape of HTML</td>
<td align="left">false</td>
</tr>
</tbody>
</table>

The compilation path is generated according to the above options, if the developer wants total freedom defining the compilation path, an anonymous function can be used to generate it, this function receives the relative path to the template in the views directory. The following examples show how to change the compilation path dynamically:

~~~~ {.sourceCode .php}
<?php

// Just append the .php extension to the template path
// leaving the compiled templates in the same directory
$volt->setOptions(
    [
        "compiledPath" => function ($templatePath) {
            return $templatePath . ".php";
        }
    ]
);

// Recursively create the same structure in another directory
$volt->setOptions(
    [
        "compiledPath" => function ($templatePath) {
            $dirName = dirname($templatePath);

            if (!is_dir("cache/" . $dirName)) {
                mkdir("cache/" . $dirName);
            }

            return "cache/" . $dirName . "/". $templatePath . ".php";
        }
    ]
);
~~~~

Extending Volt
--------------

Unlike other template engines, Volt itself is not required to run the compiled templates. Once the templates are compiled there is no dependence on Volt. With performance independence in mind, Volt only acts as a compiler for PHP templates.

The Volt compiler allow you to extend it adding more functions, tests or filters to the existing ones.

### Functions

Functions act as normal PHP functions, a valid string name is required as function name. Functions can be added using two strategies, returning a simple string or using an anonymous function. Always is required that the chosen strategy returns a valid PHP string expression:

~~~~ {.sourceCode .php}
<?php

use Phalcon\Mvc\View\Engine\Volt;

$volt = new Volt($view, $di);

$compiler = $volt->getCompiler();

// This binds the function name 'shuffle' in Volt to the PHP function 'str_shuffle'
$compiler->addFunction("shuffle", "str_shuffle");
~~~~

Register the function with an anonymous function. This case we use \$resolvedArgs to pass the arguments exactly as were passed in the arguments:

~~~~ {.sourceCode .php}
<?php

$compiler->addFunction(
    "widget",
    function ($resolvedArgs, $exprArgs) {
        return "MyLibrary\\Widgets::get(" . $resolvedArgs . ")";
    }
);
~~~~

Treat the arguments independently and unresolved:

~~~~ {.sourceCode .php}
<?php

$compiler->addFunction(
    "repeat",
    function ($resolvedArgs, $exprArgs) use ($compiler) {
        // Resolve the first argument
        $firstArgument = $compiler->expression($exprArgs[0]['expr']);

        // Checks if the second argument was passed
        if (isset($exprArgs[1])) {
            $secondArgument = $compiler->expression($exprArgs[1]['expr']);
        } else {
            // Use '10' as default
            $secondArgument = '10';
        }

        return "str_repeat(" . $firstArgument . ", " . $secondArgument . ")";
    }
);
~~~~

Generate the code based on some function availability:

~~~~ {.sourceCode .php}
<?php

$compiler->addFunction(
    "contains_text",
    function ($resolvedArgs, $exprArgs) {
        if (function_exists("mb_stripos")) {
            return "mb_stripos(" . $resolvedArgs . ")";
        } else {
            return "stripos(" . $resolvedArgs . ")";
        }
    }
);
~~~~

Built-in functions can be overridden adding a function with its name:

~~~~ {.sourceCode .php}
<?php

// Replace built-in function dump
$compiler->addFunction("dump", "print_r");
~~~~

### Filters

A filter has the following form in a template: leftExpr|name(optional-args). Adding new filters is similar as seen with the functions:

~~~~ {.sourceCode .php}
<?php

// This creates a filter 'hash' that uses the PHP function 'md5'
$compiler->addFilter("hash", "md5");
~~~~

~~~~ {.sourceCode .php}
<?php

$compiler->addFilter(
    "int",
    function ($resolvedArgs, $exprArgs) {
        return "intval(" . $resolvedArgs . ")";
    }
);
~~~~

Built-in filters can be overridden adding a function with its name:

~~~~ {.sourceCode .php}
<?php

// Replace built-in filter 'capitalize'
$compiler->addFilter("capitalize", "lcfirst");
~~~~

### Extensions

With extensions the developer has more flexibility to extend the template engine, and override the compilation of a specific instruction, change the behavior of an expression or operator, add functions/filters, and more.

An extension is a class that implements the events triggered by Volt as a method of itself.

For example, the class below allows to use any PHP function in Volt:

~~~~ {.sourceCode .php}
<?php

class PhpFunctionExtension
{
    /**
     * This method is called on any attempt to compile a function call
     */
    public function compileFunction($name, $arguments)
    {
        if (function_exists($name)) {
            return $name . "(". $arguments . ")";
        }
    }
}
~~~~

The above class implements the method 'compileFunction' which is invoked before any attempt to compile a function call in any template. The purpose of the extension is to verify if a function to be compiled is a PHP function allowing to call it from the template. Events in extensions must return valid PHP code, this will be used as result of the compilation instead of the one generated by Volt. If an event doesn't return an string the compilation is done using the default behavior provided by the engine.

The following compilation events are available to be implemented in extensions:

<table>
<col width="21%" />
<col width="78%" />
<thead>
<tr class="header">
<th align="left">Event/Method</th>
<th align="left">Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left">compileFunction</td>
<td align="left">Triggered before trying to compile any function call in a template</td>
</tr>
<tr class="even">
<td align="left">compileFilter</td>
<td align="left">Triggered before trying to compile any filter call in a template</td>
</tr>
<tr class="odd">
<td align="left">resolveExpression</td>
<td align="left">Triggered before trying to compile any expression. This allows the developer to override operators</td>
</tr>
<tr class="even">
<td align="left">compileStatement</td>
<td align="left">Triggered before trying to compile any expression. This allows the developer to override any statement</td>
</tr>
</tbody>
</table>

Volt extensions must be in registered in the compiler making them available in compile time:

~~~~ {.sourceCode .php}
<?php

// Register the extension in the compiler
$compiler->addExtension(
    new PhpFunctionExtension()
);
~~~~

Caching view fragments
----------------------

With Volt it's easy cache view fragments. This caching improves performance preventing that the contents of a block from being executed by PHP each time the view is displayed:

~~~~ {.sourceCode .html+jinja}
{% cache "sidebar" %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
~~~~

Setting a specific number of seconds:

~~~~ {.sourceCode .html+jinja}
{# cache the sidebar by 1 hour #}
{% cache "sidebar" 3600 %}
    <!-- generate this content is slow so we are going to cache it -->
{% endcache %}
~~~~

Any valid expression can be used as cache key:

~~~~ {.sourceCode .html+jinja}
{% cache ("article-" ~ post.id) 3600 %}

    <h1>{{ post.title }}</h1>

    <p>{{ post.content }}</p>

{% endcache %}
~~~~

The caching is done by the Phalcon\\\\Cache \<cache\> component via the view component. Learn more about how this integration works in the section "Caching View Fragments" \<views\>.

Inject Services into a Template
-------------------------------

If a service container (DI) is available for Volt, you can use the services by only accessing the name of the service in the template:

~~~~ {.sourceCode .html+jinja}
{# Inject the 'flash' service #}
<div id="messages">{{ flash.output() }}</div>

{# Inject the 'security' service #}
<input type="hidden" name="token" value="{{ security.getToken() }}">
~~~~

Stand-alone component
---------------------

Using Volt in a stand-alone mode can be demonstrated below:

~~~~ {.sourceCode .php}
<?php

use Phalcon\Mvc\View\Engine\Volt\Compiler as VoltCompiler;

// Create a compiler
$compiler = new VoltCompiler();

// Optionally add some options
$compiler->setOptions(
    [
        // ...
    ]
);

// Compile a template string returning PHP code
echo $compiler->compileString(
    "{{ 'hello' }}"
);

// Compile a template in a file specifying the destination file
$compiler->compileFile(
    "layouts/main.volt",
    "cache/layouts/main.volt.php"
);

// Compile a template in a file based on the options passed to the compiler
$compiler->compile(
    "layouts/main.volt"
);

// Require the compiled templated (optional)
require $compiler->getCompiledTemplatePath();
~~~~

External Resources
------------------

-   A bundle for Sublime/Textmate is available [here](https://github.com/phalcon/volt-sublime-textmate)
-   [Album-O-Rama](http://album-o-rama.phalconphp.com) is a sample application using Volt as template engine, [[Album-O-Rama on Github](https://github.com/phalcon/album-o-rama)]
-   [Our website](http://phalconphp.com) is running using Volt as template engine, [[Our website on Github](https://github.com/phalcon/website)]
-   [Phosphorum](http://forum.phalconphp.com), the Phalcon's forum, also uses Volt, [[Phosphorum on Github](https://github.com/phalcon/forum)]
-   [Vökuró](http://vokuro.phalconphp.com), is another sample application that use Volt, [[Vökuró on Github](https://github.com/phalcon/vokuro)]
