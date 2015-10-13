Every changes of our code, we should logged it here for future reference.


---


### Version v1.4.x
- Added multiple service connection
- Changed Class Preloader to use the updated version
- Changed module configuration
- Fixed the `CLI::ssh()` to be able to compile provided array
- Combined phinx settings to phalcon db settings
- Changed how the Csrf and Fatal Error handle errors
- Wrapped the Phinx Console to be under Brood Console lists
- Fixed Blade Adapter on how to render a file
- Fixed `vendor:new` brood command to prevent inserting values without slash
- Enhanced the URL Service Provider to handle separated modules
- Added `Crypt` inside the Session File Adapter
- Added Psysh as `php brood clutch` for interactive app inside slayer
- Added `composer.lock`
- Fixed `php brood serve` that doesn't support multi module call in the optione `--file`


---


### Version 1.3.x:
- Added acceptance testing using Behat/Mink
- Fixed Slayer Command
- Disabled _get instead to support REQUEST_URI on Route Service
- Added Module Service
- Added Clear Compiled console command
- Removed other storage paths
- Changed Router Service, URI Source using $_SERVER['REQUEST_URI']


---


### Version 1.2.x:
- Added Module Service
- Added Clear Compiled console command
- Removed other storage paths
- Added getter functions access to protected properties in models
- Changed and Fixed the middlewares
- Removed getClient() and the client Interface in the flysystem
- Added a separate event listener for Dispatcher and Application
- Refactored the autoload file
- Added brood commands on travis file
- Separated the phinx migration config over the database config
- Changed module 'main' base uri from **localhost** to **slayer.app**
- Added try-catch on queue worker, to prevent the loop from stopping
- Added Copy Adapter for Flysystem


---


### Version 1.0.x:
- Added cache drivers
- Fixed psr style
- Fixed base route
- Fixed Blade Adapter
- Added Faker Package for db:seed command
- Fixed the looping part for services
- Renamed slayer command to brood
- Added phpleague\tactician for Http Middleware
- Added app:controller generator
- Fixed generators for model and collection
- Added optimize command
- Fixed and Normalized the ACL Component
- Separating the [framework](http://github.com/phalconslayer/framework) from slayer, based from issue #24
- Changed the database adapters in the config
- Changed the error handler to be multiple and separated the CSRF Handler
