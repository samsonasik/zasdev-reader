<?php
namespace RSS\Service;

use RSS\Entity\Subscription;

/**
 * Interface SubscriptionServiceInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface SubscriptionServiceInterface
{
    /**
     * Returns the list of subscriptions ordered by name
     * @return Subscription[]
     */
    public function getSubscriptions();
}
