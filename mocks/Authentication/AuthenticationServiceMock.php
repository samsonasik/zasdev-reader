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
