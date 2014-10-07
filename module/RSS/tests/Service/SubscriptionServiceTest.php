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

namespace RSSTest\Service;

use Application\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit_Framework_TestCase as TestCase;
use RSS\Entity\Subscription;
use RSS\Service\SubscriptionService;
use RSS\Service\SubscriptionServiceInterface;
use ZasDev\Mock\Authentication\AuthenticationServiceMock;
use ZasDev\Mock\Doctrine\ObjectManagerMock;
use Zend\Authentication\AuthenticationServiceInterface;

/**
 * Class SubscriptionServiceTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class SubscriptionServiceTest extends TestCase
{
    /**
     * @var SubscriptionServiceInterface
     */
    protected $subscriptionService;
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    /**
     * @var AuthenticationServiceMock
     */
    protected $authService;

    public function setUp()
    {
        $this->objectManager        = new ObjectManagerMock();
        $this->authService          = new AuthenticationServiceMock();
        $this->subscriptionService  = new SubscriptionService($this->objectManager, $this->authService);
    }

    public function testSubscriptionsFormOtherUsersAreNotReturned()
    {
        $me = new User();
        $me->setId(1);
        $this->objectManager->persist($me);
        $this->authService->setIdentity($me);

        $this->objectManager->persist(new Subscription());
        $this->objectManager->persist(new Subscription());

        $this->assertCount(0, $this->subscriptionService->getSubscriptions());
    }

    public function testSubscriptionsAreOrderedByName()
    {
        $me = new User();
        $me->setId(1);
        $this->objectManager->persist($me);
        $this->authService->setIdentity($me);

        $sub1 = new Subscription();
        $sub1->setName('CC Third')
             ->setUser($me);
        $this->objectManager->persist($sub1);

        $sub2 = new Subscription();
        $sub2->setName('AA First')
             ->setUser($me);
        $this->objectManager->persist($sub2);

        $sub3 = new Subscription();
        $sub3->setName('BB Second')
             ->setUser($me);
        $this->objectManager->persist($sub3);

        $subscriptions = $this->subscriptionService->getSubscriptions();
        $this->assertCount(3, $subscriptions);
        $this->assertSame($sub2, $subscriptions[0]);
        $this->assertSame($sub3, $subscriptions[1]);
        $this->assertSame($sub1, $subscriptions[2]);
    }
}
