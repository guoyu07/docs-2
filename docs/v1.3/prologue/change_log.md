Every changes on our code, we should logged it here for future reference.


---

###Version 1.3.0:
- Added acceptance testing using Behat/Mink
- Fixed Slayer Command
- Disabled _get instead to support REQUEST_URI on Route Service
- Added Module Service
- Added Clear Compiled console command
- Removed other storage paths
- Changed Router Service, URI Source using $_SERVER['REQUEST_URI']


---


###Version 1.2.1:
- Added Module Service
- Added Clear Compiled console command
- Removed other storage paths


---


###Version 1.2.0:
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


###Version 1.0.1:
- Added cache drivers
- Fixed psr style
- Fixed base route


---

###Version 1.0.0:
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
