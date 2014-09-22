<?php
namespace RSS\Exception;

/**
 * Class FeedSaveException
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedSaveException extends FeedException
{
    public function __construct($rssEntryUUID, \Exception $previous = null)
    {
        parent::__construct(sprintf('The FeedEntry identified by "%s" couldn\'t be saved', $rssEntryUUID), $previous);
    }
}
