<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Util;


use Nette\Forms\IControl;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

class Validator extends \Nette\Utils\Validators
{
    /**
     * Ověřuje zda-li se jedná o prázdný string
     * @param string|NULL $string
     * @return bool
     */
    public static function isStringEmpty(?string $string) : bool
    {
        if ($string !== NULL)
        {
            return trim($string) === '';
        }

        return FALSE;
    }


    /**
     * Ověřuje JSON zda-li je obsah fieldu JSON
     * Pokud chcete upravovat toto pravidlo, je potřeba upravit i JS pravidlo v souboru:
     *  Module ./assets/Common/validator/js/validator.js
     *
     * @param IControl $field
     * @return bool
     */
    public static function json(IControl $field) : bool
    {
        try
        {
            Json::decode($field->getValue());
        }
        catch (JsonException $exception)
        {
            return FALSE;
        }

        return TRUE;
    }
}