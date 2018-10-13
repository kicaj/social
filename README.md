# Social plugin for CakePHP

**NOTE:** It's still in development mode, do not use in production yet!

## Requirements

It is developed for CakePHP 3.x.

## Installation

You can install plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require kicaj/social dev-master
```

Load the Plugin
-----------

Ensure the Social plugin is loaded in your config/bootstrap.php file

```
Plugin::load('Social', [
    'bootstrap' => true,
    'routes' => true,
]);
```
or add manually by `cake` command
```
cake plugin load -b -r Social
```

Usage
-----------
In Your config/bootstrap add provider configurations
```
Configure::write('Social.Google.client_id', '[CLIENT_ID]');
Configure::write('Social.Google.client_secret', '[CLIENT_SECRET]');
```

## TODOs

- Social logins (just logins)
  - [x] Google
  - [x] Facebook
  - [x] GitHub
  - [ ] Twitter
  - [ ] LinkedIn
  - [ ] BitBucket
- [ ] Separate register (and login)
- [ ] Social share
- [ ] Social meta
- [x] Expansibility logins, interface class
