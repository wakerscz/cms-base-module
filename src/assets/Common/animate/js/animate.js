/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

$(function ()
{
    $.fn.animateCss = function (options)
    {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

        var defaults = {
            animationName: 'fadeIn',
            beforeAnimate: function () {},
            afterAnimate: function () {}
        };

        var object = $.extend(defaults, options);

        if (typeof object.beforeAnimate === 'function')
        {
            object.beforeAnimate();
        }

        this.addClass('animated ' + options.animationName).one(animationEnd, function ()
        {
            $(this).removeClass('animated ' + options.animationName);

            if (typeof object.afterAnimate === 'function')
            {
                object.afterAnimate();
            }
        });
    };

});