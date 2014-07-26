<?php
namespace RSS\Exception;

/**
 * Class FeedImportException
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FeedImportException extends \Exception
{
    public function __construct($url, \Exception $previous = null)
    {
        $code = isset($previous) ? $previous->getCode() : 1;
        parent::__construct(sprintf(
            'An error occurred while importing feeds from %s',
            $url
        ), $code, $previous);
    }
}
