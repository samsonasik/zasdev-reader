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

use Application\Entity\User;
use Zend\Authentication\AuthenticationService;

/**
 * Basic implementation to handle persistent logins
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface PersistentLoginInterface
{
    /**
     * Default persistent session default lifetime in seconds. 2 weeks
     * @var int
     */
    const DEFAULT_LIFETIME = 1209600;
    /**
     * The persistent login cookie name
     * @var string
     */
    const COOKIE_NAME = "zasdevreader_al";

    /**
     * Deletes the persistent login cookie if exists and disables the corresponding session register in the database
     */
    public function delete();
    
    /**
     * Creates a new persistent login cookie for current user
     * @param User $user User object to get user information
     * @param int $lifetime Persistent login cookie lifetime in seconds
     */
    public function create(User $user, $lifetime = self::DEFAULT_LIFETIME);
    
    /**
     * Checks if a persistent login cookie exists
     * @return True if the persistent login cookie exists. False otherwise
     */
    public function hasAutoLoginCookie();
    
    /**
     * Authenticates the user using the persistent login cookie information
     * @param \Zend\Authentication\AuthenticationService $authService
     * @return True if login was properly created. False otherwise
     */
    public function authenticate(AuthenticationService $authService);
}
