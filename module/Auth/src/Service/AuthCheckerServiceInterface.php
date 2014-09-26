<?php
namespace Auth\Service;

/**
 * Interface AuthCheckerServiceInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface AuthCheckerServiceInterface
{
    /**
     * @return bool
     */
    public function checkAuthentication();
}
