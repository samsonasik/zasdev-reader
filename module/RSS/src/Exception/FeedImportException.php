<?php
namespace RSS\Exception;

/**
 * Class FeedImportException
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedImportException extends \Exception
{
    public function __construct($url, $code = 1, \Exception $previous = null)
    {
        parent::__construct(sprintf(
            'An error occurred while importing feeds from %s',
            $url
        ), $code, $previous);
    }
}
