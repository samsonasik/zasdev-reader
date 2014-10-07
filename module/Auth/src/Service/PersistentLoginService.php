<?php
/*
 * This file is part of ZasDev Reader.
 *
 * ZasDev Reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZasDev Reader is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ZasDev Reader. If not, see <http://www.gnu.org/licenses/>.
 */

namespace ZasDev\Auth\Service;

use DateTime;
use Exception;
use Auth\Entity\Session;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Http\Header\SetCookie;
use Zend\Http\Request;
use Application\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Http\Response;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;

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
     * @var HttpRequest
     */
    private $request;
    /**
     * @var HttpResponse
     */
    private $response;

    /**
     * @param ObjectManager $objectManager
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function __construct(ObjectManager $objectManager, RequestInterface $request, ResponseInterface $response)
    {
        $this->objectManager = $objectManager;
        // Use dummy response and request when provided are not HTTP
        $this->request  = ($request instanceof HttpRequest) ? $request : new HttpRequest();
        $this->response = ($response instanceof HttpResponse) ? $response : new HttpResponse();
    }

    /**
     *
     */
    public function delete()
    {
        // Get the token of the cookie if exists
        $cookies = $this->request->getHeaders()->get('Cookie');
        if (!$cookies->offsetExists(PersistentLoginInterface::COOKIE_NAME)) {
            return;
        }
        $token = $cookies->offsetGet(PersistentLoginInterface::COOKIE_NAME);

        // Disable session register from database
        $session = $this->objectManager->getRepository(Session::_CLASS)->findOneBy(array("token" => $token));
        $session->setValid(false);
        $this->objectManager->flush();

        // Delete cookie
        $cookie = new SetCookie(self::COOKIE_NAME, "", time() - 3600, "/");
        $this->response->getHeaders()->addHeader($cookie);
    }

    /**
     * @param User $user
     * @param int $lifetime
     */
    public function create(User $user, $lifetime = PersistentLoginInterface::DEFAULT_LIFETIME)
    {
        $date           = new \DateTime();
        $formattedDate  = $date->format("Y-m-d H:i:s");
        $expirationDate = new \DateTime();
        $expirationDate->setTimestamp(time() + $lifetime);

        // Generate token
        $token = sha1($formattedDate)       .   // Current date hash
                 sha1($user->getUsername()) .   // Username
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

        // Create the cookie and inject it in the response headers
        $cookie = new SetCookie(self::COOKIE_NAME, $token, $expirationDate->getTimestamp(), "/");
        $this->response->getHeaders()->addHeader($cookie);
    }

    /**
     * @return bool|True
     */
    public function hasAutoLoginCookie()
    {
        $cookies = $this->request->getHeaders()->get('Cookie');
        if (!isset($cookies) || !is_object($cookies)) {
            return false;
        }
        return $cookies->offsetExists(self::COOKIE_NAME);
    }

    /**
     * @param \Zend\Authentication\AuthenticationService $authService
     * @return bool
     */
    public function authenticate(AuthenticationService $authService)
    {
        // Get the token of the cookie if exists
        $cookies = $this->request->getHeaders()->get('Cookie');
        if (!$cookies->offsetExists(self::COOKIE_NAME)) {
            return false;
        }
        $token = $cookies->offsetGet(self::COOKIE_NAME);

        // Get session entity and user entity from session
        /** @var Session $session */
        $session = $this->objectManager->getRepository(Session::_CLASS)->findOneBy(array("token" => $token));
        if (!isset($session)) {
            return false;
        }

        // Check if session has expired or is invalid
        if ($session->getExpirationDate()->getTimestamp() < time() || !$session->isValid()) {
            return false;
        }

        // Try to authenticate the user
        /** @var AbstractAdapter $authAdapter */
        $authAdapter = $authService->getAdapter();
        $authAdapter->setIdentity($session->getUser()->getUsername());
        $authAdapter->setCredential($session->getUser()->getPassword());

        // Return the status of the authentication
        return $authService->authenticate()->isValid();
    }
}
