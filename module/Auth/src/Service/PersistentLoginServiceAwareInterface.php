<?php
namespace Auth\Service;

/**
 * Interface PersistentLoginServiceAwareInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface PersistentLoginServiceAwareInterface
{
    /**
     * Sets the persistent login service
     * @param PersistentLoginInterface $persistentLoginService
     * @return mixed
     */
    public function setPersistentLoginService(PersistentLoginInterface $persistentLoginService);

    /**
     * @return PersistentLoginInterface
     */
    public function getPersistentLoginService();
}
