<?php
namespace Auth\Service;

/**
 * Interface AuthCheckerServiceAwareInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface AuthCheckerServiceAwareInterface
{
    /**
     * @param AuthCheckerServiceInterface $authChecker
     */
    public function setAuthChecker(AuthCheckerServiceInterface $authChecker);

    /**
     * @return AuthCheckerServiceInterface
     */
    public function getAuthChecker();
}
