<?php

use Cake\Core\Configure;

Configure::write('Social', [
    'google' => [
        'login_url' => 'https://accounts.google.com/o/oauth2/v2/auth',
        'login_url_query' => [
            'access_type',
            'response_type',
            'client_id',
            'redirect_uri',
            'scope',
        ],
<<<<<<< HEAD
        'scope' => 'https://www.googleapis.com/auth/userinfo.email',
        'access_type' => 'offline',
        'response_type' => 'code',
        'redirect_uri' => [
            'plugin' => 'Social',
            'controller' => 'Logins',
            'action' => 'callback',
            'google',
        ],
=======
        'redirect_uri' => 'social/logins/callback/google',
        'scope' => 'https://www.googleapis.com/auth/userinfo.email',
        'access_type' => 'offline',
        'response_type' => 'code',
>>>>>>> origin
    ],
    'facebook' => [
        'login_url' => 'https://www.facebook.com/v2.11/dialog/oauth',
        'login_url_query' => [
            'client_id',
<<<<<<< HEAD
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
]);
=======
            'redirect_uri',
            'state',
        ],
        'redirect_uri' => 'social/logins/callback/facebook',
    ],
]);
>>>>>>> origin
