<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $config = $this->getServiceLocator()->get('Config');

        return ['providers' => $config['providers']];
    }

    public function initAction()
    {
        $config = $this->getServiceLocator()->get('Config');
        $provider = $this->getRequest()->getQuery()->get('run');
        $container = new Container('provider');

        if (!isset($config['oauth2'][$provider])) {
            throw new \Exception("$provider is not configured");
        } else {
            $oauth2Config = $config['oauth2'][$provider];
        }

        $class = "League\\OAuth2\\Client\\Provider\\$provider";
        $oauth2 = new $class($oauth2Config);
        $container->lastProvider = $provider;

        return $this->plugin('redirect')->toUrl($oauth2->getAuthorizationUrl());
    }

    public function callbackAction()
    {
        $config = $this->getServiceLocator()->get('Config');
        $container = new Container('provider');

        $provider = $container->lastProvider;

        $class = "League\\OAuth2\\Client\\Provider\\$provider";
        $oauth2Config = $config['oauth2'][$provider];
        $oauth2 = new $class($oauth2Config);

        $state = (isset($_GET['state'])) ? $_GET['state']: null;

        $t = $oauth2->getAccessToken('authorization_code', array(
            'code' => $_GET['code'],
            'state' => $state
        ));

        $valid = false;
        if ($t instanceOf \League\OAuth2\Client\Token\AccessToken) {
            $valid = true;
        }

        unset($container->lastProvider);

        return [
            'valid' => $valid, 
            'provider' => $provider,
            'token' => $t,
            'providers' => $config['providers'],
        ];
    }
}
