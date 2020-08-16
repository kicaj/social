# Social plugin for CakePHP

**NOTE:** It's still in development mode, do not use in production yet!

## Requirements

It is developed for CakePHP 4.x.

## Installation

You can install plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require kicaj/social dev-master
```

Load the Plugin
-----------

Ensure the Social plugin is loaded in your src/Application.php file

```
$this->addPlugin('Social');
```

Usage
-----------
In your `config/bootstrap.php` or `app_local.php` add providers configuration
```
Configure::write('Social.Google.client_id', '[CLIENT_ID]');
Configure::write('Social.Google.client_secret', '[CLIENT_SECRET]');
```

When user correctly login, you can use event listener named `Social.login`.


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
