<?php
namespace ZasDev\Mock\Authentication;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\Result;

/**
 * Class AuthenticationServiceMock
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class AuthenticationServiceMock implements AuthenticationServiceInterface
{
    private $identity;
    private $forceError = false;

    /**
     * Authenticates and provides an authentication result
     *
     * @return Result
     */
    public function authenticate()
    {
        if ($this->forceError) {
            return new Result(-1, null);
        } else {
            return new Result(1, $this->identity);
        }
    }

    /**
     * Tells if the method authenticate should fail on the next calls
     * @param bool $forceError
     */
    public function forceAuthenticationFail($forceError = true)
    {
        $this->forceError = $forceError;
    }

    /**
     * Sets the identity returned when calling authenticate
     * @param $identity
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    /**
     * Returns true if and only if an identity is available
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return isset($this->identity);
    }

    /**
     * Returns the authenticated identity or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Clears the identity
     *
     * @return void
     */
    public function clearIdentity()
    {
        $this->identity = null;
    }
}
