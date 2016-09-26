`Phalcon\Db` is the component behind `Phalcon\Mvc\Model` that powers the model layer in the framework. It consists of an independent high-level abstraction layer for database systems completely written in C.

<div class="alert alert-danger">
<i class="fa fa-warning"></i> This guide is not intended to be a complete documentation of available methods and their arguments. Please visit the <a href="https://docs.phalconphp.com/en/latest/api/index.html" target="_blank">API</a> for a complete reference.
</div>

## Index
- [Connection](#connection)
- [Finding Rows](#finding-rows)
- [Binding Parameters](#binding-parameters)
- [Inserting/Updating/Deleting Rows](#inserting-updating-deleting-rows)
- [Transactions and Nested Transactions](#transactions-and-nested-transactions)
- [Database Events](#database-events)
- [Profiling SQL Statements](#profiling-sql-statements)
- [Logging SQL Statements](#logging-sql-statements)
- [Describing Tables/Views](#describing-tables-views)


# <a href="#connection" name="connection">Connection</a>

Assume that we have the index `sqlite` in our `{project-root}/config/database.php`, and we want that connection to use. You may call it these way:

```php
$connection = \DB::connection('sqlite');

# or

$connection = db()->connection('sqlite');
```

# <a href="#finding-rows" name="finding-rows">Finding Rows</a>

`Phalcon\Db` provides several methods to query rows from tables. The specific SQL syntax of the target database engine is required in this case:

```php
$sql = "SELECT id, name FROM robots ORDER BY name";

# send a SQL statement to the database system
$result = $connection->query($sql);

# print each robot name
while ($robot = $result->fetch()) {
   echo $robot["name"];
}

# get all rows in an array
$robots = $connection->fetchAll($sql);
foreach ($robots as $robot) {
   echo $robot["name"];
}

# get only the first row
$robot = $connection->fetchOne($sql);
```

By default these calls create arrays with both associative and numeric indexes. You can change this behavior by using `Phalcon\Db\Result::setFetchMode()`. This method receives a constant, defining which kind of index is required.

| Constant                | Description                                                                                                                  |
|-------------------------|------------------------------------------------------------------------------------------------------------------------------|
| Phalcon\Db::FETCH_NUM   | Return an array with numeric indexes                                                                                         |
| Phalcon\Db::FETCH_ASSOC | Return an array with associative indexes Phalcon\Db::FETCH_BOTH  Return an array with both associative and numeric indexes   |
| Phalcon\Db::FETCH_OBJ   | Return an object instead of an arrays                                                                                        |

```php
$sql = "SELECT id, name FROM robots ORDER BY name";

$result = $connection->query($sql);

$result->setFetchMode(Phalcon\Db::FETCH_NUM);

while ($robot = $result->fetch()) {
   echo $robot[0];
}
```

The `Phalcon\Db::query()` returns an instance of `Phalcon\Db\Result\Pdo`. These objects encapsulate all the functionality related to the returned resultset i.e. traversing, seeking specific records, count etc.

```php
$sql = "SELECT id, name FROM robots";

$result = $connection->query($sql);

# traverse the resultset
while ($robot = $result->fetch()) {
   echo $robot["name"];
}

# seek to the third row
$result->seek(2);
$robot = $result->fetch();

# count the resultset
echo $result->numRows();
```

# <a href="#binding-parameters" name="binding-parameters">Binding Parameters</a>

Bound parameters is also supported in `Phalcon\Db`. Although there is a minimal performance impact by using bound parameters, you are encouraged to use this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks. Both string and positional placeholders are supported. Binding parameters can simply be achieved as follows:

```php
# binding with numeric placeholders
$sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
$result = $connection->query($sql, ["Wall-E"]);

# binding with named placeholders
$sql     = "INSERT INTO `robots`(name`, year) VALUES (:name, :year)";
$success = $connection->query($sql, ["name" => "Astro Boy", "year" => 1952]);
```

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case “1” or “2” are considered strings and not numbers, so the placeholder could not be successfully replaced. With any adapter data are automatically escaped using <a href="http://php.net/manual/en/pdo.quote.php" target="_blank">PDO Quote</a>.

This function takes into account the connection charset, so its recommended to define the correct charset in the connection parameters or in your database server configuration, as a wrong charset will produce undesired effects when storing or retrieving data.

Also, you can pass your parameters directly to the execute/query methods. In this case bound parameters are directly passed to PDO:

```php
# binding with PDO placeholders
$sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
$result = $connection->query($sql, [1 => "Wall-E"]);
```

# <a href="#inserting-updating-deleting-rows" name="inserting-updating-deleting-rows">Inserting/Updating/Deleting Rows</a>

To insert, update or delete rows, you can use raw SQL or use the preset functions provided by the class:

```php
# Inserting data with a raw SQL statement
$sql     = "INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)";
$success = $connection->execute($sql);

# With placeholders
$sql     = "INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)";
$success = $connection->execute($sql, ['Astro Boy', 1952]);

# Generating dynamically the necessary SQL
$success = $connection->insert(
   "robots",
   ["Astro Boy", 1952],
   ["name", "year"]
);

# Generating dynamically the necessary SQL (another syntax)
$success = $connection->insertAsDict(
   "robots",
   [
      "name" => "Astro Boy",
      "year" => 1952
   ]
);

# updating data with a raw SQL statement
$sql     = "UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101";
$success = $connection->execute($sql);

# with placeholders
$sql     = "UPDATE `robots` SET `name` = ? WHERE `id` = ?";
$success = $connection->execute($sql, ['Astro Boy', 101]);

# generating dynamically the necessary SQL
$success = $connection->update(
   "robots",
   ["name"],
   ["New Astro Boy"],
   "id = 101" # warning! In this case values are not escaped
);

# generating dynamically the necessary SQL (another syntax)
$success = $connection->updateAsDict(
   "robots",
   [
      "name" => "New Astro Boy"
   ],
   "id = 101" # warning! In this case values are not escaped
);

# with escaping conditions
$success = $connection->update(
   "robots",
   ["name"],
   ["New Astro Boy"],
   [
      'conditions' => 'id = ?',
      'bind' => [101],
      'bindTypes' => [PDO::PARAM_INT] # optional parameter
   ]
);
$success = $connection->updateAsDict(
   "robots",
   [
      "name" => "New Astro Boy"
   ],
   [
      'conditions' => 'id = ?',
      'bind' => [101],
      'bindTypes' => [PDO::PARAM_INT] # optional parameter
   ]
);

# deleting data with a raw SQL statement
$sql     = "DELETE `robots` WHERE `id` = 101";
$success = $connection->execute($sql);

# with placeholders
$sql     = "DELETE `robots` WHERE `id` = ?";
$success = $connection->execute($sql, [101]);

# generating dynamically the necessary SQL
$success = $connection->delete("robots", "id = ?", [101]);
```

# <a href="#transactions-and-nested-transactions" name="transactions-and-nested-transactions">Transactions and Nested Transactions</a>

Working with transactions is supported as it is with PDO. Perform data manipulation inside transactions often increase the performance on most database systems:

```php
try {

    # start a transaction
    $connection->begin();

    # execute some SQL statements
    $connection->execute("DELETE `robots` WHERE `id` = 101");
    $connection->execute("DELETE `robots` WHERE `id` = 102");
    $connection->execute("DELETE `robots` WHERE `id` = 103");

    # commit if everything goes well
    $connection->commit();

} catch (Exception $e) {
    # an exception has occurred rollback the transaction
    $connection->rollback();
}
```

In addition to standard transactions, `Phalcon\Db` provides built-in support for nested transactions (if the database system used supports them). When you call begin() for a second time a nested transaction is created:

```php
try {

    # start a transaction
    $connection->begin();

    # execute some SQL statements
    $connection->execute("DELETE `robots` WHERE `id` = 101");

    try {

        # start a nested transaction
        $connection->begin();

        # execute these SQL statements into the nested transaction
        $connection->execute("DELETE `robots` WHERE `id` = 102");
        $connection->execute("DELETE `robots` WHERE `id` = 103");

        # create a save point
        $connection->commit();

    } catch (Exception $e) {
        # an error has occurred, release the nested transaction
        $connection->rollback();
    }

    # continue, executing more SQL statements
    $connection->execute("DELETE `robots` WHERE `id` = 104");

    # commit if everything goes well
    $connection->commit();

} catch (Exception $e) {
    # an exception has occurred rollback the transaction
    $connection->rollback();
}
```

# <a href="#database-events" name="database-events">Database Events</a>

`Phalcon\Db` is able to send events to a `EventsManager` if it’s present. Some events when returning boolean false could stop the active operation. The following events are supported:

|Event Name          | Triggered                                              | Can stop operation?  |
|--------------------|--------------------------------------------------------|----------------------|
|afterConnect        | After a successfully connection to a database system   | No                   |
|beforeQuery         | Before send a SQL statement to the database system     | Yes                  |
|afterQuery          | After send a SQL statement to database system          | No                   |
|beforeDisconnect    | Before close a temporal database connection            | No                   |
|beginTransaction    | Before a transaction is going to be started            | No                   |
|rollbackTransaction | Before a transaction is rollbacked                     | No                   |
|commitTransaction   | Before a transaction is committed                      | No                   |

Bind an `EventsManager` to a connection is simple, `Phalcon\Db` will trigger the events with the type `db`:

```php
use Phalcon\Events\Manager as EventsManager;

// ...

$manager = new EventsManager();

$manager->attach('db', function ($event, $conn) {

    if ($event->getType() == 'beforeQuery') {
        // ...
    }
});

$connection->setEventsManager($manager);
```

Stop SQL operations are very useful if for example you want to implement some last-resource SQL injector checker:

```php
$manager->attach('db:beforeQuery', function ($event, $conn) {

    # check for malicious words in SQL statements
    if (preg_match('/DROP|ALTER/i', $conn->getSQLStatement())) {
        # DROP/ALTER operations aren't allowed in the application,
        # this must be a SQL injection!
        return false;
    }

    # it's OK
    return true;
});
```

# <a href="#profiling-sql-statements" name="profiling-sql-statements">Profiling SQL Statements</a>

`Phalcon\Db` includes a profiling component called `Phalcon\Db\Profiler`, that is used to analyze the performance of database operations so as to diagnose performance problems and discover bottlenecks.

Database profiling is really easy With `Phalcon\Db\Profiler`:

```php

use ... as EventsManager;
use Phalcon\Db\Profiler as DbProfiler;

// ...

$profiler = new DbProfile;

$manager->attach('db', function ($event, $connection) use ($profiler) {
    if ($event->getType() == 'beforeQuery') {
        # start a profile with the active connection
        $profiler->startProfile($connection->getSQLStatement());
    }

    if ($event->getType() == 'afterQuery') {
        # stop the active profile
        $profiler->stopProfile();
    }
});

# assign the events manager to the connection
$connection->setEventsManager($manager);

$sql = "SELECT buyer_name, quantity, product_name "
     . "FROM buyers "
     . "LEFT JOIN products ON buyers.pid = products.id";

# execute a SQL statement
$connection->query($sql);

# get the last profile in the profiler
$profile = $profiler->getLastProfile();

echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
echo "Start Time: ", $profile->getInitialTime(), "\n";
echo "Final Time: ", $profile->getFinalTime(), "\n";
echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
```

You can also create your own profile class based on `Phalcon\Db\Profiler` to record real time statistics of the statements sent to the database system:

```php
<?php

use Phalcon\Db\Profiler as Profiler;
use Phalcon\Db\Profiler\Item as Item;
use Phalcon\Events\Manager as EventsManager;

class DbProfiler extends Profiler
{
    /**
     * Executed before the SQL statement will sent to the db server
     */
    public function beforeStartProfile(Item $profile)
    {
        echo $profile->getSQLStatement();
    }

    /**
     * Executed after the SQL statement was sent to the db server
     */
    public function afterEndProfile(Item $profile)
    {
        echo $profile->getTotalElapsedSeconds();
    }
}

# create an Events Manager
$eventsManager = new EventsManager();

# create a listener
$dbProfiler = new DbProfiler();

# attach the listener listening for all database events
$eventsManager->attach('db', $dbProfiler);
```

# <a href="#logging-sql-statements" name="logging-sql-statements">Logging SQL Statements</a>

When calling `\DB::connection(...)`, everytime you query, it always logs all the statements which is located at `{project-root}/storage/logs/db.log`.

This is implemented under the class `Clarity\Providers\DB::getEventLogger()` which uses `beforeQuery` to be able to log previous sql statements.

# <a href="#describing-tables-views" name="describing-tables-views">Describing Tables/Views</a>

`Phalcon\Db` also provides methods to retrieve detailed information about tables and views:

```php
# get tables on the slayer database
$tables = $connection->listTables("slayer");

# is there a table 'robots' in the database?
$exists = $connection->tableExists("robots");

# get name, data types and special features of 'robots' fields
$fields = $connection->describeColumns("robots");
foreach ($fields as $field) {
    echo "Column Type: ", $field["Type"];
}

# get indexes on the 'robots' table
$indexes = $connection->describeIndexes("robots");
foreach ($indexes as $index) {
    print_r($index->getColumns());
}

# get foreign keys on the 'robots' table
$references = $connection->describeReferences("robots");
foreach ($references as $reference) {
    # print referenced columns
    print_r($reference->getReferencedColumns());
}
```

A table description is very similar to the MySQL describe command, it contains the following information:

| Index    | Description |
|----------|--------------|
| Field    | Field’s name |
| Type     | Column Type |
| Key      | Is the column part of the primary key or an index? |
| Null     | Does the column allow null values? |

Methods to get information about views are also implemented for every supported database system:

```php
# get views on the slayer database
$tables = $connection->listViews("slayer");

# is there a view 'robots' in the database?
$exists = $connection->viewExists("robots");
```
