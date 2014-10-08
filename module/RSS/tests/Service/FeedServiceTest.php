<?php
namespace ZasDev\RSSTest\Service;

use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit_Framework_TestCase as TestCase;
use ZasDev\Mock\Authentication\AuthenticationServiceMock;
use ZasDev\Mock\Doctrine\ObjectManagerMock;
use ZasDev\RSS\Entity\FeedEntry;
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
}
