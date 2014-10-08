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

namespace ZasDev\Mock\ServiceManager;

use Zend\ServiceManager\Exception;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ServiceManagerMock
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class ServiceManagerMock implements ServiceLocatorInterface
{
    /**
     * @var array()
     */
    private $services;

    public function __construct(array $services = array())
    {
        $this->services = $services;
    }

    /**
     * Retrieve a registered instance
     *
     * @param  string $name
     * @throws Exception\ServiceNotFoundException
     * @return object|array
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new Exception\ServiceNotFoundException(sprintf(
                "Service with name %s not found",
                $name
            ));
        }

        return $this->services[$name];
    }

    /**
     * Check for a registered instance
     *
     * @param  string|array $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->services);
    }

    /**
     * Sets the service with defined key
     * @param $key
     * @param $service
     * @return $this
     */
    public function set($key, $service)
    {
        $this->services[$key] = $service;
        return $this;
    }
}
