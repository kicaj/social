<?php
namespace Social\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
<<<<<<< HEAD
use Cake\Core\Exception\Exception;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Social\Controller\Component\Interfaces\LoginInterface;
=======
use Cake\Http\Client;
use Cake\Network\Exception\BadRequestException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Routing\Router;
>>>>>>> origin

class LoginsController extends AppController
{

    /**
     * {@inheritDoc}
<<<<<<< HEAD
=======
     *
     * @see \App\Controller\AppController::initialize()
>>>>>>> origin
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow([
            'callback'
        ]);
<<<<<<< HEAD

        if (isset($this->request->params['pass'][0])) {
            $provider = $this->request->params['pass'][0];

            // Read configuration
            $this->config = Configure::readOrFail('Social.' . $provider);

            // Load provider component
            // @todo Rebuild for separate components between from plugin and from app
            if (!isset($this->config['component'])) {
                $this->config['component'] = 'Social.' . Inflector::classify($provider);
            }

            echo $this->config['component'];

            list(, $component) = pluginSplit($this->config['component']);

            $this->loadComponent($this->config['component'], $this->config);

            $this->component = $this->{$component};
        } else {
            throw new Exception('Brak providera');
        }
=======
>>>>>>> origin
    }

    /**
     * Provider callback
     *
<<<<<<< HEAD
     * @param string $provider Name of provider
     */
    public function callback($provider)
    {
        if ($this->component instanceof LoginInterface) {
            if (isset($this->request->query['code']) && !empty($code = $this->request->query['code'])) {
                $login = $this->component->login($this->request->query['code']);

                // @todo Get configuration of Authenticate
                $authenticate = $this->Auth->getAuthenticate('Form');

                // Get User based on FormAuthenticate finder
                // @todo What with other authenticates
                $user = TableRegistry::get($authenticate->getConfig('userModel'))->find($authenticate->getConfig('finder'))->andWhere([
                    $authenticate->getConfig('fields.username') => $login,
                ])->first();

                if (!empty($user)) {
                    // Manually login
                    $this->Auth->setUser($user->toArray());

                    $this->redirect($this->Auth->getConfig('loginRedirect'));
                } else {
                    throw new Exception('Z: ' . print_r($user));
                }
            } else {
                throw new Exception('Brak parametrow code');
            }
        } else {
            throw new Exception('Brak implementacji interfejsu LoginInterface');
=======
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
            	'redirect_uri' => Router::url('/', true) . $config['redirect_uri'],
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
>>>>>>> origin
        }
    }
}
