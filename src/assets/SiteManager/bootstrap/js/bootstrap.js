/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

$(function ()
{
    $.nette.ext('bootstrap',
    {
        load: function ()
        {
            $('.tooltip, .popover').remove();

            $('[data-toggle="tooltip"], [data-tooltip="tooltip"]').tooltip();

            $('[data-toggle="popover"], [data-popover="popover"]').popover();
        }
    });
});