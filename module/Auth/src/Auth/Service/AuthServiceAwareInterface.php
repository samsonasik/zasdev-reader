<?php
namespace Auth\Service;

use Zend\Authentication\AuthenticationService;

/**
 * 
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface AuthServiceAwareInterface
{
    
    /**
     * @param \Zend\Authentication\AuthenticationService $authService
     */
    public function setAuthService(AuthenticationService $authService);
    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService();
    
}