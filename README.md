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
Plugin::load('Social');
```

## TODOs

- Social logins
  - [x] Google
  - [x] Facebook
  - [ ] Twitter
  - [ ] LinkedIn
  - [ ] GitHub
  - [ ] BitBucket
- [ ] Social share
- [ ] Social meta
- [x] Expansibility logins, interface class
