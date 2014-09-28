<?php
namespace RSS\Exception;

/**
 * Class FeedImportException
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedImportException extends FeedException
{
    public function __construct($url, \Exception $previous = null)
    {
        parent::__construct(sprintf(
            'An error occurred while importing feeds from %s',
            $url
        ), $previous);
    }
}
