You can learn how to install phalcon slayer, how to initially setup your environment.

## Index:
- [Requirements](#requirements)
- [Project Creation](#project-creation)
- [Dot Environment](#dot-environment)
- [Web Server](#web-server)

# <a href="#requirements" name="requirements">Requirements</a>

Before installing, there are plenty of tools that we need to install.

- Required
    - PHP version atleast 5.5.9
    - <a href="setup-installation-phalcon.html">Phalcon as Extension</a>
    - [Composer](https://getcomposer.org/)
    - [cURL](https://curl.haxx.se)
- For Queueing
    - You are required to install [Beanstalkd](http://kr.github.io/beanstalkd/) for queueing.

---

# <a href="#project-creation" name="project-creation">Project Creation</a>

Using composer, you can create a new project, write this code on your terminal:

```shell
composer create-project phalconslayer/slayer --prefer-dist <folder name>
```

After running the above command, there must be an output, similar below:

```shell
Installing phalconslayer/slayer (version)
  - Installing phalconslayer/slayer (version)
    Downloading: 100%

Created project in folderName
> php -r "copy('.env.example', '.env');"
Loading composer repositories with package information
Installing dependencies (including require-dev)
```

---

# <a href="#dot-environment" name="dot-environment">Dot Environment</a>

Let's assume that we have a  `local` / `staging` / `production` servers. The `local` comes with multiple `developers`, however we don't want our developers to view those credentials, such as our production database, mail credentials, aws access token and many more that we think they're confidential.

On your project root, we have `.env.example` file, copy this file and name it as `.env`. Furthermore, this file handles a global constant value, assume the constant value below:

```shell
DB_HOST=192.168.10.10
```

You can access the constant value `DB_HOST` by using the function `env({NAME_HERE}, {default value})`

Try to check the file `config/database.php`, and find the `env('DB_HOST', 'localhost')`, if there will be no value in our source, it will be based on the default value which is `localhost`

**Note:**
This file is already ignored under your [`GIT Distributed Version Control`](https://git-scm.com/)

# <a href="#web-server" name="web-server">Web Server</a>

Slayer has configurations for Apache2 and NginX, it is located at:
- {project-root}/storage/etc/nginx/sites-available/
- {project-root}/storage/etc/apache2/sites-available/

we have an example, find `slayer.app` file for both web server in the directory above listed, you could copy the file and put it in your web server or you may apply a symlink in it.

Let us say we have an NginX under UbuntuOS:

```shell
cd /etc/nginx/sites-enabled/
ln -s ../../../var/www/phalconslayer/slayer/storage/etc/nginx/sites-available/slayer.app
sudo service nginx restart
```

The command above shows that you must be located at the nginx `sites-enabled` and you must call the command `ln -s` to apply symlink. We've also restarted the nginx server.

Add a domain on your `/etc/hosts` file and point it to your local ip address, you should be able to access your local website

To verify, you can try the console command below.

```shell
curl -v -s slayer.app 1> /dev/null
```

The curl command above must return this kind of format, that shows an `HTTP/1.1 200 OK`

```shell
* Connected to slayer.app (192.168.10.10) port 80 (#0)
> GET / HTTP/1.1
> User-Agent: curl/7.35.0
> Host: slayer.app
> Accept: */*
>
< HTTP/1.1 200 OK
* Server nginx/1.8.0 is not blacklisted
< Server: nginx/1.8.0
< Date: Thu, 03 Mar 2016 00:45:27 GMT
< Content-Type: text/html; charset=UTF-8
< Transfer-Encoding: chunked
< Connection: keep-alive
< Set-Cookie: slayer=ojoo6udniihctp11hcjh1hcll3; path=/
< Expires: Thu, 19 Nov 1981 08:52:00 GMT
< Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
< Pragma: no-cache
```
