<?php
namespace RSS\Entity;

use Zend\Feed\Reader\Entry\AbstractEntry;

/**
 * Interface RssEntryExchangeableInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface RssEntryExchangeableInterface
{
    /**
     * Populates this element with content on defined entry
     * @param AbstractEntry $entry
     * @return $this
     */
    public function exchangeRssEntry(AbstractEntry $entry);
}
