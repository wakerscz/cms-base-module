/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

$(function ()
{
    Lobibox.notify.DEFAULTS = $.extend({}, Lobibox.notify.DEFAULTS,
    {
        soundPath: '/temp/static/sound/notification/',
        //iconSource: 'fontAwesome',
        icon: false,
        sound: 'sound4',
        width: 320,
        height: null,
        pauseDelayOnHover: true,
        continueDelayOnInactiveTab: false
    });

    /*Lobibox.notify.OPTIONS.icons.fontAwesome = $.extend({}, Lobibox.notify.OPTIONS.icons.fontAwesome,
    {
        default: 'fa fa-paper-plane',
        error: 'fa fa-exclamation-triangle'
    });*/

    $.notification = function (type, title, message)
    {
        var delay = 7000;

        if (type === 'error' || type === 'warning')
        {
            delay = false
        }

        Lobibox.notify(type,
        {
            title: title,
            msg: message,
            delay: delay
        });
    };

    $.nette.ext('notifications',
    {
        success: function (payload, status, jqXHR, settings)
        {
            var notifications = payload.notifications;

            if (typeof notifications !== 'undefined')
            {
                notifications.reverse().forEach(function (notification)
                {
                    $.notification(
                        notification.type,
                        notification.title,
                        notification.message
                    );
                });
            }
        }
    });
});