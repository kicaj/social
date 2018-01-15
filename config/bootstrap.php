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
        'redirect_uri' => '/social/logins/callback/google',
        'scope' => 'https://www.googleapis.com/auth/userinfo.email',
        'access_type' => 'offline',
        'response_type' => 'code',
    ],
    'facebook' => [
        'login_url' => 'https://www.facebook.com/v2.11/dialog/oauth',
        'login_url_query' => [
            'client_id',
            'redirect_uri',
            'state',
        ],
        'redirect_uri' => '/social/logins/callback/facebook',
    ],
]);