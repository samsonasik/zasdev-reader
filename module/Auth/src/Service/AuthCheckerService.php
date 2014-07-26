<?php
namespace Auth\Service;

use Auth\Options\AuthOptions;
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
     * The routes whitelist must contain the login routes. This is merged with user defined routes
     * @var array
     */
    private $baseWhitelist = array(
        'login',
        'logout'
    );

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
    protected $persistentLogin;
    /**
     * @var AuthOptions
     */
    protected $options;

    public function __construct(AuthOptions $options)
    {
        $this->options = $options;
    }

    /**
     * @return bool
     */
    public function checkAuthentication()
    {
        $hasIdentity = $this->authService->hasIdentity() && $this->authService->getIdentity() != null;

        if (!$hasIdentity && !$this->isInWhiteList() && !$this->persistentLogin->hasAutoLoginCookie()) {
            // The user is not logued in, does not have a login cookie and is trying to go to a section other than login
            // => Redirect to login
            return false;
        } elseif (!$hasIdentity && !$this->isInWhiteList() && $this->persistentLogin->hasAutoLoginCookie()) {
            // The user is not logued in, is not going to login but he has a login cookie
            // => Try to use the cookie to authenticate
            if (!$this->persistentLogin->createAutoLogin($this->authService)) {
                return false;
            }
        }

        // The current user is not going to the login => change the layout to display app
        if (!$this->isInWhiteList()) {
            $this->event->getViewModel()->setTemplate("layout/layout");
        } else {
            $this->event->getViewModel()->setTemplate("layout/login");
        }

        // In any other case continue...
        return true;
    }

    /**
     * Checks if current route is one of the routes that should be dispatched even if there is not a user logued in
     * @return bool
     */
    private function isInWhiteList()
    {
        $routeMatch = $this->event->getRouteMatch();
        if (!isset($routeMatch)) {
            return false;
        }

        return in_array(
            $routeMatch->getMatchedRouteName(),
            array_merge($this->baseWhitelist, $this->options->getRoutesWhitelist())
        );
    }

    /**
     * @param AuthenticationService $authService
     * @return $this
     */
    public function setAuthService(AuthenticationService $authService)
    {
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
    public function setEvent(MvcEvent $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @param $persistentLogin
     * @return $this
     */
    public function setPersistentLogin($persistentLogin)
    {
        $this->persistentLogin = $persistentLogin;
        return $this;
    }
}
