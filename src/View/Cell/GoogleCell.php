<?php
namespace Social\View\Cell;

use Cake\View\Cell;
use Cake\Core\Configure;

class GoogleCell extends Cell
{

    /**
     * Login button
     */
    public function display()
    {
        $provider = Configure::readOrFail('Social.google');

        $url = $provider['login_url'] . '?' . http_build_query(array_intersect_key($provider, array_flip($provider['login_url_query'])));

        $this->set(compact('url'));
    }

}