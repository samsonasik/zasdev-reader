<?php
namespace Auth\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;

/**
 * Checks authentication on WebService module
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class AuthCheckerService implements AuthServiceAwareInterface, AuthCheckerServiceInterface
{

    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    protected $authService;
    /**
     * @var MvcEvent
     */
    protected $event;
    /**
     * @var \Auth\Service\PersistentLoginInterface
     */
    private $persistentLogin;
    /**
     * @var array
     */
    private $linksWhiteList = array("login", "logout");

    /**
     * @return bool
     */
    public function checkAuthentication() {
        return $this->checkAppAuthentication();
    }

    /**
     * @return bool
     */
    private function checkAppAuthentication() {
        $hasIdentity = $this->authService->hasIdentity() && $this->authService->getIdentity() != null; // TODO Solving bug on Doctrine authentication service.

        // The user is not logued in, does not have a login cookie and is trying to go to a section other than login => Redirect to login
        if (!$hasIdentity && !$this->isInWhiteList() && !$this->persistentLogin->hasAutoLoginCookie())
            return false;

        // The user is not logued in, is not going to login but he has a login cookie => Try to use the cookie to authenticate
        else if (!$hasIdentity && !$this->isInWhiteList() && $this->persistentLogin->hasAutoLoginCookie()) {
            if (!$this->persistentLogin->createAutoLogin($this->authService))
                return false;
        }

        // The current user is not going to the login => change the layout to display app
        if (!$this->isInWhiteList())
            $this->event->getViewModel()->setTemplate("layout/layout.phtml");
        else
            $this->event->getViewModel()->setTemplate("layout/login-layout.phtml");

        // In any other case continue...
        return true;
    }

    /**
     * Checks if current route is one of the routes that should be dispatched even if there is not a user logued in
     * @return bool
     */
    private function isInWhiteList() {
        $routeMatch = $this->event->getRouteMatch();
        if (!isset($routeMatch))
            return false;
        return in_array($routeMatch->getMatchedRouteName(), $this->linksWhiteList);
    }

    /**
     * @param AuthenticationService $authService
     * @return $this
     */
    public function setAuthService(AuthenticationService $authService) {
        $this->authService = $authService;
        return $this;
    }
    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * @param MvcEvent $event
     * @return $this
     */
    public function setEvent(MvcEvent $event) {
        $this->event = $event;
        return $this;
    }

    /**
     * @param $persistentLogin
     * @return $this
     */
    public function setPersistentLogin($persistentLogin) {
        $this->persistentLogin = $persistentLogin;
        return $this;
    }

}