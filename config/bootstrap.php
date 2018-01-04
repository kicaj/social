<?php

use Cake\Core\Configure;

Configure::write('Social', [
    'google' => [
        'login_url' => 'https://accounts.google.com/o/oauth2/v2/auth',
        'login_url_query' => [
            'access_type',
            'response_type',
            'redirect_uri',
            'client_id',
            'scope',
        ],
        'redirect_uri' => '/social/logins/callback/google',
        'scope' => 'https://www.googleapis.com/auth/userinfo.email',
        'access_type' => 'offline',
        'response_type' => 'code',
    ],
    'facebook' => [
        'redirect_uri' => '/social/logins/callback/facebook',
    ],
]);