<?php

return [

    // Tasks
    //
    // Here you can define in the `before` and `after` array, Tasks to execute
    // before or after the core Rocketeer Tasks. You can either put a simple command,
    // a closure which receives a $task object, or the name of a class extending
    // the Rocketeer\Abstracts\AbstractTask class
    //
    // In the `custom` array you can list custom Tasks classes to be added
    // to Rocketeer. Those will then be available in the command line
    // with all the other tasks
    //////////////////////////////////////////////////////////////////////

    // Tasks to execute before the core Rocketeer Tasks
    'before' => [
        'setup'   => [],
        'deploy'  => [],
        'cleanup' => [],
    ],

    // Tasks to execute after the core Rocketeer Tasks
    'after'  => [
        'setup'   => [],
        'deploy'  => [
            function ($task) {
                return $task->runForCurrentRelease('php ./vendor/bin/pure-themer');
            },
            function ($task) {
                $oldRelease = $task->releasesManager->getPreviousRelease();
                $oldRelease = $task->releasesManager->getPathToRelease($oldRelease).'/public';

                $newRelease = $task->releasesManager->getCurrentReleasePath().'/public';


                $content = file_get_contents(__DIR__.'/nginx/beta-docs.phalconslayer.com');
                $content = str_replace('{www_folder}', $newRelease, $content);

                return $task->run([
                    // 'sed -i \'s#root "'.$oldRelease.'";#root "'.$newRelease.'";#g\' /etc/nginx/sites-enabled/docs.phalconslayer.com',
                    'echo -e "'.$content.'" > /etc/nginx/sites-available/beta-docs.phalconslayer.com',
                ]);
            },
            function ($task) {
                $task->run('sudo service nginx restart');
            },
        ],
        'cleanup' => [
        ],
    ],

    // Custom Tasks to register with Rocketeer
    'custom' => [],

];
