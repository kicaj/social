<?php
namespace Social\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Social\Controller\Component\Interfaces\LoginInterface;

class LoginsController extends AppController
{

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow([
            'callback'
        ]);

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
    }

    /**
     * Provider callback
     *
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
        }
    }
}
