/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

$(function()
{
    $.run = function()
    {
        $.nette.ext(
            'ajax-link',
            {
                load: function ()
                {
                    $('a[data-ajax-link]').each(function ()
                    {
                        $(this).attr('href', $(this).data('ajax-link'));
                    });
                }
            }
        );

        $.nette.init();

        console.info('Created with love ♥ Wakers');
        console.info('www.wakers.cz | 606 091 125');
    };
});