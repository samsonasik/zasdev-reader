<?php
namespace ZasDev\RSSTest\Service;

use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit_Framework_TestCase as TestCase;
use ZasDev\Mock\Authentication\AuthenticationServiceMock;
use ZasDev\Mock\Doctrine\ObjectManagerMock;
use ZasDev\RSS\Entity\FeedEntry;
use ZasDev\RSS\Entity\Subscription;
use ZasDev\RSS\Service\FeedService;
use Zend\Authentication\AuthenticationServiceInterface;

/**
 * Class FeedServiceTest
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedServiceTest extends TestCase
{
    /**
     * @var FeedService
     */
    private $feedService;
    /**
     * @var ObjectManagerMock
     */
    private $objectManager;
    /**
     * @var AuthenticationServiceInterface
     */
    private $authService;

    public function setUp()
    {
        $this->objectManager = new ObjectManagerMock(include __DIR__ . '/../repository_map.php');
        $this->authService = new AuthenticationServiceMock();
        $this->feedService = new FeedService($this->objectManager, $this->authService);
    }

    public function testSaveFeed()
    {
        $feedEntry = new FeedEntry();
        $feedEntry->setTitle('The title')
                  ->setBody('The body');
        $this->assertSame($this->feedService, $this->feedService->saveFeed($feedEntry));
        $this->assertNotNull($feedEntry->getId());
        $this->assertSame($feedEntry, $this->objectManager->find(FeedEntry::_CLASS, $feedEntry->getId()));
    }

    /**
     * @expectedException \ZasDev\RSS\Exception\FeedSaveException
     */
    public function testSaveExceptionWithError()
    {
        $feedEntry = new FeedEntry();
        $feedEntry->setTitle('The title')
                  ->setBody('The body');
        $this->objectManager->setThrowException();
        $this->feedService->saveFeed($feedEntry);
    }

    public function testGetUnreadFeeds()
    {
        $unreadFeeds = 30;
        $readedFeeds = 40;
        $subscription = new Subscription();
        $subscription->setName('The subscription');
        $this->objectManager->persist($subscription);
        $this->createMultipleUnreadFeeds($unreadFeeds, array('subscription' => $subscription));
        $this->createMultipleUnreadFeeds($readedFeeds, array('unread' => false, 'subscription' => $subscription));

        $this->assertCount(20, $this->feedService->getUnreadFeeds($subscription));
        $this->assertCount(10, $this->feedService->getUnreadFeeds($subscription, 10));
        $this->assertCount($unreadFeeds, $this->feedService->getUnreadFeeds($subscription, 1000));
        $this->assertCount(10, $this->feedService->getUnreadFeeds($subscription, 20, 20));
        $this->assertCount(0, $this->feedService->getUnreadFeeds(null));
        $this->assertCount(0, $this->feedService->getUnreadFeeds(new Subscription()));
    }

    public function testGetStarredFeeds()
    {
        $unstarredFeeds = 30;
        $starredFeeds = 40;
        $subscription = new Subscription();
        $subscription->setName('The subscription');
        $this->objectManager->persist($subscription);
        $this->createMultipleUnreadFeeds($unstarredFeeds, array('subscription' => $subscription));
        $this->createMultipleUnreadFeeds($starredFeeds, array('starred' => true, 'subscription' => $subscription));

        $this->assertCount(20, $this->feedService->getStarredFeeds($subscription));
        $this->assertCount(10, $this->feedService->getStarredFeeds($subscription, 10));
        $this->assertCount($starredFeeds, $this->feedService->getStarredFeeds($subscription, 1000));
        $this->assertCount(15, $this->feedService->getStarredFeeds($subscription, 20, 25));
        $this->assertCount(0, $this->feedService->getStarredFeeds(null));
        $this->assertCount(0, $this->feedService->getStarredFeeds(new Subscription()));
    }

    public function testSaveFeeds()
    {
        $subscription = new Subscription();
        $subscription->setName('The subscription');
        $this->objectManager->persist($subscription);
        $feeds = $this->createMultipleUnreadFeeds(10, array('subscription' => $subscription), false);

        $this->assertCount(0, $this->objectManager->getRepository(FeedEntry::_CLASS)->findAll());
        $this->assertSame($this->feedService, $this->feedService->saveFeeds($feeds));
        $this->assertCount(count($feeds), $this->objectManager->getRepository(FeedEntry::_CLASS)->findAll());
    }

    /**
     * Creates some temporary FeedEntries, with random title and body and provided properties list
     * @param $length
     * @param array $baseProperties
     * @param boolean $persist
     * @return FeedEntry[]
     */
    private function createMultipleUnreadFeeds($length, array $baseProperties = array(), $persist = true)
    {
        $length = (int) $length;
        $feeds = array();
        for ($i = 1; $i <= $length; $i++) {
            $feedEntry = new FeedEntry();
            $feedEntry->setId($i)
                      ->setTitle($this->generateRandomString(10))
                      ->setBody($this->generateRandomString(500));

            $feedEntry->exchangeArray($baseProperties);
            $feeds[] = $feedEntry;
            if ($persist) {
                $this->objectManager->persist($feedEntry);
            }
        }

        return $feeds;
    }

    /**
     * Generates a random string of provided length
     * @param $length
     * @return string
     */
    private function generateRandomString($length)
    {
        $characters = ' 0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
