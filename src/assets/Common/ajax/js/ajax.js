/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

$(function ()
{
    var init = $.nette.ext('init');

    init.linkSelector = 'a[data-ajax]';
    init.formSelector = 'form[data-ajax]';
    init.buttonSelector = 'input[data-ajax][type="submit"], button[data-ajax][type="submit"], input[data-ajax][type="image"]';
});