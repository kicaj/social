<?php
namespace Social\View\Cell;

use Cake\View\Cell;
use Cake\Core\Configure;
use Cake\Routing\Router;

class LoginCell extends Cell
{

    /**
     * Login button
     *
     * @param null|string $provider Short name of provider
     */
    public function display($provider = null)
    {
        $config = Configure::readOrFail('Social.' . $provider);

<<<<<<< HEAD
        // Add redirect_uri
        Configure::write('Social.' . $provider . '.redirect_uri', $config['redirect_uri'] = Router::url([
            'plugin' => 'Social',
            'controller' => 'Logins',
            'action' => 'callback',
            $provider,
        ], true));
=======
        // Add fullbase URL
        $config['redirect_uri'] = Router::url('/', true) . $config['redirect_uri'];
>>>>>>> origin

        $url = $config['login_url'] . '?' . http_build_query(array_intersect_key($config, array_flip($config['login_url_query'])));

        $this->set(compact('url'));
    }
}
