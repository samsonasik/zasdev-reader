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

namespace ZasDev\RSS\Service;

use ZasDev\RSS\Entity\Subscription;
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
            array('user' => $this->authService->getIdentity()),
            array('name' => 'ASC')
        );
    }
}
