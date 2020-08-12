<?php
namespace Social\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Social\Controller\Component\Interfaces\LoginInterface;
use Social\Exception\ProviderException;
use Social\Exception\CodeException;
use Social\Exception\InterfaceException;

class LoginsController extends AppController
{

    /**
     * Social component
     *
     * @var string
     */
    protected $_component;

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        parent::initialize();

        // Remove layout and view rendering
        $this->viewBuilder()->setLayout(false);
        $this->render(false);

        $this->Auth->allow([
            'callback',
        ]);

        if (($provider = Inflector::classify($this->request->getParam('pass.0'))) !== null) {
            // Read configuration
            $this->config = Configure::readOrFail($this->plugin . '.' . $provider);

            // Load provider component
            if (!isset($this->config['component'])) {
                $this->config['component'] = $this->plugin . '.' . $provider;
            }

            $this->loadComponent($this->config['component'], $this->config);

            list(, $component) = pluginSplit($this->config['component']);

            $this->_component = $this->{$component};
        } else {
            throw new ProviderException(__d('social', 'The social provider is not implemented!'));
        }
    }

    /**
     * Provider callback
     *
     * @param string $provider Name of provider
     */
    public function callback($provider)
    {
        if ($this->_component instanceof LoginInterface) {
            if ($this->request->getQuery('code') !== null && !empty($code = $this->request->getQuery('code'))) {
                $login = $this->_component->login($code);

                // @todo Get configuration of Authenticate
                $authenticate = $this->Auth->getAuthenticate('Form');

                // Get User based on FormAuthenticate finder
                // @todo What with other authenticates
                $user = TableRegistry::get($authenticate->getConfig('userModel'))->find($authenticate->getConfig('finder'))->andWhere([
                    $authenticate->getConfig('userModel') . '.' . $authenticate->getConfig('fields.username') => $login,
                ])->first();

                if (!empty($user)) {
                    // Manually login
                    $this->Auth->setUser($user->toArray());

                    $this->redirect($this->Auth->getConfig('loginRedirect'));
                } else {
                    $this->Flash->error(__d('social', 'User {0} is not registered!', $login));

                    return $this->redirect($this->Auth->getConfig('loginAction'));
                }
            } else {
                throw new CodeException(__d('social', 'Missing code query parameter.'));
            }
        } else {
            throw new InterfaceException(__d('social', 'Social provider should use LoginInterface.'));
        }
    }
}
