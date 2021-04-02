# Laravel Package Docker Development Tools

This repo aims to help developers maintain external Laravel packages.

Includes folders

- `host` default Laravel instance
- `docker` config files
- `package` folders for each of packages

## Launching

`docker-compose up -d` should be enough

- Laravel is at http://localhost:1000
- Adminer (database UI) is at http://localhost:8079/

By default Laravel is using `mysql` DB, but you can change this in `host/.env` file

### CLI Commands. `artisan` & `composer`

Enter bash by calling `docker-compose exec escola_lms_app bash`, then lanuch any command like `artisan` or `composer`.

## How to use this

Repeat those steps for each package

1. Clone your package to a folder inside this repo, eg `package` (`git clone XXX package`). Add your folder to `.gitignore`
2. Add folder to Docker volumes, amend `docker-compose.yml`

Before:

```yaml
escola_lms_app:
  image: escolasoft1/laravel-prod-docker:fpm
  command: bash -c "/etc/init.d/cron start && php-fpm -F"
  volumes:
    - ./host:/var/www/html
    - ./docker/php-custom.ini:/usr/local/etc/php/conf.d/php-custom.ini
    - ./docker/xxx-devilbox-default-php.ini:/usr/local/etc/php/conf.d/xxx-devilbox-default-php.ini
```

After:

```yaml
escola_lms_app:
  image: escolasoft1/laravel-prod-docker:fpm
  command: bash -c "/etc/init.d/cron start && php-fpm -F"
  volumes:
    - ./host:/var/www/html
    - ./docker/php-custom.ini:/usr/local/etc/php/conf.d/php-custom.ini
    - ./docker/xxx-devilbox-default-php.ini:/usr/local/etc/php/conf.d/xxx-devilbox-default-php.ini
    - ./package:/var/www/package
```

3. Amend Host Laravel `host/composer.json`

Before:

```json
"repositories": {
}
```

After:

```json
"repositories": {
    "escolalms/headless-h5p": {
        "type": "path",
        "url": "../package"
    }
}
```

Note that name (`escolalms/headless-h5p` in example above) **MUST** match one you have in `package/composer.json`

4. Restart docker `docker-compose stop escola_lms_app`, `docker-compose up escola_lms_app -d`
5. Enter bash (instruction above), then add you packge with `composer require escolalms/headless-h5p`

That's it - now you have laravel working with docker that is using package from other folder that is `git` maintained.

## Xdebug remote debbuging

_Note_ instruction below is for VSCODE, yet it should work with minor changes in other IDEs like PHPStorm.

1. Add mapping to `.vscode/launch.json`

Before:

```json
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html": "${workspaceFolder}/host",
            }
        },
```

After:

```json
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html": "${workspaceFolder}/host",
                "/var/www/package": "${workspaceFolder}/package"
            }
        },
```

2. Enable Xdebug

_Note_ instruction below is for VSCODE, nad Xdebug 3 (included in this Docker), port 9003 yet it should work with minor changes in other IDEs like PHPStorm.
Our settings is based on [DevilBox (Configure Xdebug)](https://devilbox.readthedocs.io/en/latest/intermediate/configure-php-xdebug.html#configure-xdebug).

1. Uncomment all Xdebug settings from `docker/xxx-devilbox-default-php.ini`
2. [Add host address alias](https://devilbox.readthedocs.io/en/latest/howto/xdebug/host-address-alias-an-mac.html#howto-host-address-alias-on-mac), eg on MacOS `sudo ifconfig lo0 alias 10.254.254.254`
3. Restart docker with docker-compose stop escola_lms_app && docker-compose rm escola_lms_app && docker-compose up -d
4. [Install default Xdebug debugging tools](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug)
5. Add at least one breakpoint to your package
6. Select option `Listen for Xdebug` from IDE debugger
7. Run your app with XDEBUG GET query param, example `http://localhost:1000/api/hh5p/library?XDEBUG_SESSION_START=VSCODE`
8. Debugger should stop on breakpoint in IDE
