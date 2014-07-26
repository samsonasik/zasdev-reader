<?php
namespace Auth\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class AuthOptions
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class AuthOptions extends AbstractOptions
{
    protected $routesWhitelist = array(
        'login',
        'logout'
    );

    /**
     * @param array $routesWhitelist
     * @return $this;
     */
    public function setRoutesWhitelist($routesWhitelist)
    {
        $this->routesWhitelist = $routesWhitelist;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoutesWhitelist()
    {
        return $this->routesWhitelist;
    }
}
