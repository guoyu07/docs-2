<?php

return [
    'Prologue' => [
        'Change Log'         => __DIR__.'/prologue/change_log.md',
        'Contribution Guide' => __DIR__.'/prologue/contribution_guide.md',
    ],
    'Setup' => [
        'Installation'  => [
            'Phalcon' => __DIR__.'/setup/installation-phalcon.md',
            'Slayer'  => __DIR__.'/setup/installation-slayer.md',
        ],
        'Configuration'       => __DIR__.'/setup/configuration.md',
        'Directory Structure' => __DIR__.'/setup/directory-structure.md',
    ],
    'Modular MVC' => [
        'Module'     => __DIR__.'/mmvc/module.md',
        'Controller' => __DIR__.'/mmvc/controller.md',
        'View'       => __DIR__.'/mmvc/view.md',
        'Model'      => __DIR__.'/mmvc/model.md',
        'Collection' => __DIR__.'/mmvc/collection.md',
    ],
    'Supporting Structure' => [
        'Error Handler'    => __DIR__.'/supporting_structure/error_handler.md',
        'Sandbox'          => __DIR__.'/supporting_structure/sandbox.md',
        'Service Provider' => __DIR__.'/supporting_structure/service_provider.md',
        'Storage'          => __DIR__.'/supporting_structure/storage.md',
        'Unit Testing'     => __DIR__.'/supporting_structure/unit_testing.md',
        'Validation'       => __DIR__.'/supporting_structure/validation.md',
    ],
    'Services' => [
        'Auth'                 => __DIR__.'/services/auth.md',
        'Cache'                => __DIR__.'/services/cache.md',
        'DB'                   => __DIR__.'/services/db.md',
        // 'Dispatcher'           => __DIR__.'/services/dispatcher.md',
        'Flash'                => __DIR__.'/services/flash.md',
        'FlashBag'             => __DIR__.'/services/flash_bag.md',
        'Flysystem'            => __DIR__.'/services/flysystem.md',
        'Lang'                 => __DIR__.'/services/lang.md',
        'Log'                  => __DIR__.'/services/logger.md',
        'Mail'                 => __DIR__.'/services/mail.md',
        'Mongo'                => __DIR__.'/services/mongo.md',
        'Redirect'             => __DIR__.'/services/redirect.md',
        'Request'              => __DIR__.'/services/request.md',
        'Response'             => __DIR__.'/services/response.md',
        'Router'               => __DIR__.'/services/router.md',
        'Session'              => __DIR__.'/services/session.md',
        'URL'                  => __DIR__.'/services/url.md',
        'View'                 => __DIR__.'/services/view.md',
    ],
    'Templates' => [
        'Volt' => __DIR__.'/templates/volt.md',
        'Blade' => __DIR__.'/templates/blade.md',
    ],
    'Misc.' => [
        'Brood Console' => __DIR__.'/misc/brood_console.md',
        'Database' => [
            'Factories'  => __DIR__.'/misc/database/factories.md',
            'Migrations' => __DIR__.'/misc/database/migrations.md',
        ],
        'Coding Style'   => __DIR__.'/misc/coding-style.md',
    ],
];
