<?php
use Cake\Core\Configure;

Configure::write('Social', array_replace_recursive([
    'Google' => [
        'login_url' => 'https://accounts.google.com/o/oauth2/v2/auth',
        'login_url_query' => [
            'access_type',
            'response_type',
            'client_id',
            'redirect_uri',
            'scope',
        ],
        'scope' => 'https://www.googleapis.com/auth/userinfo.email',
        'access_type' => 'offline',
        'response_type' => 'code',
        'redirect_uri' => [
            'plugin' => 'Social',
            'controller' => 'Logins',
            'action' => 'callback',
            'google',
        ],
    ],
    'Facebook' => [
        'login_url' => 'https://www.facebook.com/v2.11/dialog/oauth',
        'login_url_query' => [
            'client_id',
            'response_type',
            'redirect_uri',
            'scope'
        ],
        'scope' => 'email',
        'response_type' => 'code',
        'redirect_uri' => [
            'plugin' => 'Social',
            'controller' => 'Logins',
            'action' => 'callback',
            'facebook',
        ],
    ],
    'Github' => [
        'login_url' => 'https://github.com/login/oauth/authorize',
        'login_url_query' => [
            'client_id',
            'redirect_uri',
            'scope',
        ],
        'scope' => 'user',
        'redirect_uri' => [
            'plugin' => 'Social',
            'controller' => 'Logins',
            'action' => 'callback',
            'github',
        ],
    ]
], Configure::read('Social')));
