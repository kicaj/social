<?php
namespace Social\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Social\Controller\Component\Interfaces\LoginInterface;
use Social\Exception\CodeException;
use Social\Exception\ProviderException;
use Social\Exception\InterfaceException;

class LoginsController extends AppController
{

    /**
     * Social component
     *
     * @var string
     */
    protected $component;

    /**
     * {@inheritDoc}
     */
    public function initialize(): void
    {
        parent::initialize();

        if (($provider = Inflector::classify($this->request->getParam('pass.0'))) !== null) {
            // Read configuration
            $this->config = Configure::readOrFail($this->plugin . '.' . $provider);

            // Load provider component
            if (!isset($this->config['component'])) {
                $this->config['component'] = $this->plugin . '.' . $provider;
            }

            $this->loadComponent($this->config['component'], $this->config);

            list(, $component) = pluginSplit($this->config['component']);

            $this->component = $this->{$component};
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
        if ($this->component instanceof LoginInterface) {
            if ($this->request->getQuery('code') !== null && !empty($code = $this->request->getQuery('code'))) {
                $login = $this->component->login($code);

                if ($login) {
                    $this->getEventManager()->dispatch(new Event('Social.login', $this, compact('login')));
                }
            } else {
                throw new CodeException(__d('social', 'Missing code query parameter.'));
            }
        } else {
            throw new InterfaceException(__d('social', 'Social provider should use LoginInterface.'));
        }
    }
}
