/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

$(function ()
{
    /**
     *
     * @param elem
     * @param args
     * @param value
     * @return {boolean}
     * @constructor
     */
    Nette.validators.WakersBaseModuleUtilValidator_json = function (elem, args, value)
    {
        try
        {
            JSON.parse(value);
        }
        catch (exception)
        {
            return false;
        }

        return true;
    };
});