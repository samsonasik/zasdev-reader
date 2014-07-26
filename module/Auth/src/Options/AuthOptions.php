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
    /**
     * @var array
     */
    protected $routesWhitelist = array();

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
