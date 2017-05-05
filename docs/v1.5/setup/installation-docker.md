Phalcon 1.5 ships with docker support. Docker is the only thing which is required to run phalcon.

### Install docker for your system from [Docker Websiste](https://www.docker.com/get-docker)

### Usage with docker
Slayer has a helper bash script on root directory called "docker", and it accepts the following parameters

- [up](#docker-up)
- [stop](#docker-stop)
- [down](#docker-down)
- [install](#install)
- [update](#update)
- [optimize](#optimize)
- [composer](#composer)
- [bash](#bash)
- [any brood command](#brood)

## <a name="docker-up">./docker up</a>

This fires `docker-compose -f storage/.docker/docker-compose.yml up` and starts all containers. All the arguments
are forwarded to `docker-compose` command so you can also execute `./docker up -d` for detached mode


## <a name="docker-stop">./docker stop</a>
When running in detached mode, this will stop containers without removing them.


## <a name="docker-down">./docker down</a>

This fires `docker-compose -f storage/.docker/docker-compose.yml down` and removes all containers.


## <a name="install">./docker install</a>

This installs all the development dependencies. This is where you can install your additional dependencies (for eg `npm install`)


## <a name="update">./docker update</a>

This updates all the development dependencies. This is where you can update your additional dependencies (for eg `npm update`)


## <a name="optimize">./docker optimize</a>

This optimizes project for production environment. This is where you can optimize additional things(for eg `npm build:prod`)


## <a name="composer">./docker composer</a>

Firing `composer` directly from host machine.


## <a name="bash">./docker bash</a>

This is for interacting with the php-fpm container so you can tinker with the container itself.


## <a name="brood">./docker *</a>

Any unrecognized option other than mentioned above will be forwarded to brood. eg(./docker db:migrate)


# All docker related settings are under ./storage/.docker directory.
You can tinker around and change it the way you like.

## PHP configuration
docker uses the overwrite.ini file under `./storage/.docker` directory.

## xdebug
TODO: add docs on xdebug