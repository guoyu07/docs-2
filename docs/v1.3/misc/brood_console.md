We have a console tool called "brood" that provides scaffolding, database migrations and many more.


## Basic Usage

To execute a command, go to your project folder and run this console command:

```shell
$ php brood
```

It should show a lists of commands like this

```shell
Brood (c) Daison Cariño version v1.3.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output,                                                                                                                                                  2 for more verbose output and 3 for debug

Available commands:
  env              Get current environment
  help             Displays help for a command
  list             Lists commands
  optimize         Compile all the classes in to a single file.
  run              Automated scripts to be run.
  serve            Serve the application on the PHP development server
 app
  app:controller   Generate a new controller
  app:module       Generate a new module
  app:route        Generate a new route group
 clear
  clear:all        Clear all listed
  clear:cache      Clear the storage/cache folder
  clear:compiled   Clear the compiled classes
  clear:logs       Clear the storage/logs folder
  clear:session    Clear the storage/session folder
  clear:views      Clear the storage/views folder
 db
  db:create        Create a new migration
  db:migrate       Migrate the database
  db:rollback      Rollback the last or to a specific migration
  db:seed:create   Create a new database seeder
  db:seed:factory  Seed based on the factories
  db:seed:run      Run database seeders
  db:status        Show migration status
 mail
  mail:inliner     Inline templates to make it suitable for emails
 make
  make:collection  Create a new collection
  make:console     Generate a new console
  make:model       Generate a database model
 queue
  queue:worker     Generalized Queue Worker
 vendor
  vendor:publish   Publish a vendor package
```

# Creating Console

You can create your own console command by executing this to your console

```shell
$ php brood make:console <name>
```

This command generates a ***php*** class file, located at `project-name/components/Console/<name>.php

In your class, there is `$name` and `$description`, change it to allow brood to organize the commands, register your console located at `project-name/config/consoles.php`.

Run `php brood`, the assigned `$name` must be listed there.


---


# Slash

This handles the calls when executing your console


---


# Arguments

This part requires an argument to be passed in, let's assume running `php brood make:console <name>` means having the `<name>` as an argument.

The sample in the generated has a multidimensional array, so you can have multiple arguments to be called.

The inside array's first index is the **title** you want to describe, and to get the inserted value you should call `$this->input->getArgument('title');`

The array's second index is the mode of the argument, you can check the lists of available mode

| Model                    | Value                                                                                                              |
|--------------------------|--------------------------------------------------------------------------------------------------------------------|   
| InputArgument::REQUIRED  | The argument is required                                                                                           |
| InputArgument::OPTIONAL  | The argument is optional and therefore can be omitted                                                              |
| InputArgument::IS_ARRAY  | The argument can contain an indefinite number of arguments and must be used at the end of the argument list        |

The array's third index is the argument's description


---


# Options

This part is an optional to passed in, most commands has double slashes such as `--help` or `--verbose` those are the options calls.

The sample in the generated has the same multidimensional array, which you could also have a multi options to be called.

The inside array's first index is the **title** as well which will be triggered when calling `--<title>`, to get the passed value once the command executed, you could call this `$this->input->getOption('title');`

The second index is the shortcut, maybe you wan't to make it as **t** that refers as the **title**.

The third index is the option, below is the lists of available options

| Option                          |   Value                                                                             |
|---------------------------------|-------------------------------------------------------------------------------------|
| InputOption::VALUE_IS_ARRAY     |   This option accepts multiple values (e.g. --dir=/foo --dir=/bar)                  |
| InputOption::VALUE_NONE         |   Do not accept input for this option (e.g. --yell)                                 |
| InputOption::VALUE_REQUIRED     |   This value is required (e.g. --iterations=5), the option itself is still optional |
| InputOption::VALUE_OPTIONAL     |   This option may or may not have a value (e.g. --yell or --yell=loud)              |

The fourth is the description of your option

and The fifth by default is `null` which you could pass a value


---


# Explanation and Reference

We simplified the process of creating a console, as reference you can still review the library we used, the Symfony Console Component.

***Link:*** [http://symfony.com/doc/current/components/console/introduction.html](http://symfony.com/doc/current/components/console/introduction.html)
