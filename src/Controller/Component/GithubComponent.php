<?php
namespace Social\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Client;
use Cake\Core\Exception\Exception;
use Cake\Routing\Router;
use Social\Controller\Component\Interfaces\LoginInterface;

class GithubComponent extends Component implements LoginInterface
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

        $response = $client->post('https://github.com/login/oauth/access_token', [
            'code' => $code,
            'client_id' => $this->_config['client_id'],
            'client_secret' => $this->_config['client_secret'],
            'redirect_uri' => Router::url($this->_config['redirect_uri'], true),
        ], [
            'ssl_verify_peer' => false,
            'ssl_verify_peer_name' => false,
        ]);

        if ($response->isOk()) {
            parse_str($response->body(), $result);

            $response = $client->get('https://api.github.com/user/emails', [
                'access_token' => $result['access_token'],
            ], [
                'ssl_verify_peer' => false,
                'ssl_verify_peer_name' => false,
            ]);

            if ($response->isOk()) {
                return $response->json[0]['email'];
            } else {
                throw new Exception('A: ' . $response->json['message']);
            }
        } else {
            throw new Exception('B: ' . $response->json['error']);
        }
    }
}