<?php
namespace Social\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Client;
use Cake\Core\Exception\Exception;
use Cake\Routing\Router;
use Social\Controller\Component\Interfaces\LoginInterface;

class FacebookComponent extends Component implements LoginInterface
{

    /**
     * Login
     *
     * @param null|string $code Authorization code
     * @return $string User e-mail
     */
    public function login($code = null)
    {
        $client = new Client();

        $response = $client->post('https://graph.facebook.com/v2.11/oauth/access_token', [
            'code' => $code,
            'client_id' => $this->_config['client_id'],
            'client_secret' => $this->_config['client_secret'],
            'redirect_uri' => Router::url($this->_config['redirect_uri'], true),
        ]);

        if ($response->isOk()) {
            $response = $client->get('https://graph.facebook.com/me?', [
                 'access_token' => $response->json['access_token'],
                 'fields' => 'email',
            ]);

            if ($response->isOk()) {
                return $response->json['email'];
            } else {
                throw new Exception('A: ' . $response->json['error_description']);
            }
        } else {
            throw new Exception('B: ' . $response->json['error']);
        }
    }
}
