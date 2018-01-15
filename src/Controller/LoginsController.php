<?php
namespace Social\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Network\Exception\BadRequestException;
use Cake\Datasource\Exception\RecordNotFoundException;

class LoginsController extends AppController
{

    /**
     * {@inheritDoc}
     *
     * @see \App\Controller\AppController::initialize()
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow([
            'callback'
        ]);
    }

    /**
     * Provider callback
     *
     * @param null|string $provider Short name of provider
     */
    public function callback($provider = null)
    {
        $config = Configure::readOrFail('Social.' . $provider);

        if (isset($this->request->query['code']) && !empty($code = $this->request->query['code'])) {
            $http = new Client();

            $response = $http->post('https://accounts.google.com/o/oauth2/token', [
                'code' => $code,
                'client_id' => $config['client_id'],
                'client_secret' => $config['client_secret'],
                'redirect_uri' => $config['redirect_uri'],
                'grant_type' => 'authorization_code',
            ], [
                'ssl_verify_peer' => false,
                'ssl_verify_peer_name' => false,
            ]);

            if ($response->isOk()) {
                $response = $http->get('https://www.googleapis.com/oauth2/v3/tokeninfo', [
                    'id_token' => $response->json['id_token']
                ], [
                    'ssl_verify_peer' => false,
                    'ssl_verify_peer_name' => false,
                ]);

                if ($response->isOk()) {
                    echo $this->Auth->getConfig('finder');
                    //$user = $this->Users->find()->wher
                    $this->Auth->setUser([
                        'email' => $response->json['email']
                    ]);

                    $this->redirect($this->Auth->getConfig('loginRedirect'));
                } else {
                    throw new BadRequestException('A: ' . $response->json['error_description']);
                }
            } else {
                throw new BadRequestException('B: ' . $response->json['error_description']);
            }
        } else {
            throw new RecordNotFoundException('C');
        }
    }
}
