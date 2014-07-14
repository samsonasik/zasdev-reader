<?php
namespace Auth\Service;

use DateTime;
use Exception;
use Application\Entity\Session;
use Zend\Debug\Debug;
use Zend\Http\Request;
use Application\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Handles creation and deletion of persistent login cookies
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class PersistentLoginService implements PersistentLoginInterface
{
    
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $objectManager;
    /**
     * @var \Zend\Http\Request
     */
    private $request;

    /**
     * @param ObjectManager $objectManager
     * @param Request $request
     */
    public function __construct(ObjectManager $objectManager, Request $request) {
        $this->objectManager    = $objectManager;
        $this->request          = $request;
    }

    /**
     *
     */
    public function delete() {
	    // Get the token of the cookie if exists
	    $cookies = $this->request->getHeaders()->get('Cookie');
	    if (!$cookies->offsetExists(PersistentLoginInterface::COOKIE_NAME)) return;
	    $token = $cookies->offsetGet(PersistentLoginInterface::COOKIE_NAME);
	    
	    // Disable session register from database
	    $session = $this->objectManager->getRepository(Session::_CLASS)->findOneBy(array("token" => $token));
	    $session->setValid(false);
	    $this->objectManager->flush();
	    
	    // Delete cookie
		setcookie(self::COOKIE_NAME, "", time() - 3600, "/");
	}

    /**
     * @param User $user
     * @param int $lifetime
     */
    public function create(User $user, $lifetime = PersistentLoginInterface::DEFAULT_LIFETIME) {
	    $date			= new \DateTime();
	    $formattedDate 	= $date->format("Y-m-d H:i:s");
	    $expirationDate = new \DateTime();
	    $expirationDate->setTimestamp(time() + $lifetime);
	    
	    // Generate token
	    $token = sha1($formattedDate)       . 	// Current date hash
	             sha1($user->getUser())	    . 	// Username
				 sha1(rand(0, 999999999));      // Random number hash
	    
	    // Create session database register
	    $session = new Session();
	    $session->setToken($token)
	            ->setValid(true)
	            ->setExpirationDate($expirationDate)
	            ->setUser($user)
	            ->setIpAddress($this->request->getServer()->get('REMOTE_ADDR'));
	    // Persist session
	    $this->objectManager->persist($session);
	    $this->objectManager->flush();
	    
	    // TODO Use the response object to inject a cookie by using ZF methods
	    // Create the cookie and inject it in the response headers
	    setcookie(self::COOKIE_NAME, $token, $expirationDate->getTimestamp(), "/");
	}

    /**
     * @return bool|True
     */
    public function hasAutoLoginCookie() {
		$cookies = $this->request->getHeaders()->get('Cookie');
		if (!isset($cookies) || !is_object($cookies)) return false;
	    return $cookies->offsetExists(self::COOKIE_NAME);
	}

    /**
     * @param \Zend\Authentication\AuthenticationService $authService
     * @return bool|True
     */
    public function createAutoLogin($authService) {
	    // Get the token of the cookie if exists
	    $cookies = $this->request->getHeaders()->get('Cookie');
	    if (!$cookies->offsetExists(self::COOKIE_NAME)) return false;
	    $token = $cookies->offsetGet(self::COOKIE_NAME);

	    // Get session entity and user entity from session
	    try {
            $session    = $this->objectManager->getRepository(Session::_CLASS)->findOneBy(array("token" => $token));
            $user       = $session->getUser();
	    } catch (Exception $e) {
	        return false;
	    }

	    // Check if session has expired or is invalid
	    if ($session->getExpirationDate()->getTimestamp() < time() || !$session->isValid())
	        return false;

	    // Try to authenticate the user
	    $authAdapter = $authService->getAdapter();
	    $authAdapter->setIdentity($user->getUser());
	    $authAdapter->setCredential($user->getPass());
	    $result = $authService->authenticate();
	    
	    // If authentication was valid, store the user data
	    if ($result->isValid()) {
	        $authService->getStorage()->write($authService->getIdentity());
	        return true;
	    }
	    
	    return false;
	}
    
}