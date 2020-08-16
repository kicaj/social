<?php
namespace Social\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Client;
use Cake\Core\Exception\Exception;
use Cake\Routing\Router;
use Social\Controller\Component\Interfaces\LoginInterface;

class GoogleComponent extends Component implements LoginInterface
{

    /**
     * Login
     *
     * @param null|string $code Authorization code.
     * @return $string User e-mail.
     */
    public function login($code = null): string
    {
        $client = new Client();

        $response = $client->post('https://accounts.google.com/o/oauth2/token', [
            'code' => $code,
            'client_id' => $this->getConfig('client_id'),
            'client_secret' => $this->getConfig('client_secret'),
            'grant_type' => 'authorization_code',
            'redirect_uri' => Router::url($this->getConfig('redirect_uri'), true),
        ], [
            'ssl_verify_peer' => false,
            'ssl_verify_peer_name' => false,
        ]);

        if ($response->isOk()) {
            $response = $client->get('https://www.googleapis.com/oauth2/v3/tokeninfo', [
                'id_token' => $response->getJson()['id_token'],
            ], [
                'ssl_verify_peer' => false,
                'ssl_verify_peer_name' => false,
            ]);

            if ($response->isOk()) {
                return $response->getJson()['email'];
            } else {
                throw new Exception('A: ' . $response->getJson()['error_description']);
            }
        } else {
            throw new Exception($response->getJson()['error']);
        }
    }
}
