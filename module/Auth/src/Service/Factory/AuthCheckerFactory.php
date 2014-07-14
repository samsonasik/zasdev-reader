<?php
namespace Auth\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use Auth\Service\AuthCheckerService;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * 
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class AuthCheckerFactory implements FactoryInterface
{
	
	/**
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(ServiceLocatorInterface $serviceLocator) {
		$service = new AuthCheckerService;
		$service->setAuthService($serviceLocator->get('Zend\Authentication\AuthenticationService'))
                ->setPersistentLogin($serviceLocator->get('Auth\Service\PersistentLoginService'));
		return $service;
	}    
    
}