<?php
namespace RSS\Service;

use RSS\Entity\Subscription;
use ZasDev\Common\Service\AbstractService;

/**
 * Class SubscriptionService
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class SubscriptionService extends AbstractService implements SubscriptionServiceInterface
{
    /**
     * Returns the list of subscriptions ordered by name
     * @return Subscription[]
     */
    public function getSubscriptions()
    {
        return $this->objectManager->getRepository(Subscription::_CLASS)->findBy(
            array(),
            array('name' => 'ASC')
        );
    }
}
