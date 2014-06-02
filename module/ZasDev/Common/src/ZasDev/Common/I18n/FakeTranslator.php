<?php
namespace ZasDev\Common\I18n;

/**
 * This class is only intended to add "translate" method ussages in elements that are automatically translated by ZF2.
 * This allows strings ot be found by applications like Poedit
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class FakeTranslator
{

    /**
     * This method returns its argument as is
     * @param $string
     * @return mixed
     */
    public static function translate($string)
    {
        return $string;
    }

} 