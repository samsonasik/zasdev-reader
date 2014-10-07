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

namespace ZasDev\RSS\Controller;

use ZasDev\RSS\Service\FeedServiceInterface;
use ZasDev\RSS\Service\SubscriptionServiceInterface;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FeedControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        /** @var TranslatorInterface $translator */
        $translator = $serviceLocator->getServiceLocator()->get('Translator');
        /** @var FeedServiceInterface $feedService */
        $feedService = $serviceLocator->getServiceLocator()->get('RSS\Service\FeedService');
        /** @var SubscriptionServiceInterface $subscriptionService */
        $subscriptionService = $serviceLocator->getServiceLocator()->get('RSS\Service\SubscriptionService');

        return new FeedController($feedService, $subscriptionService, $translator);
    }
}
