/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

$(function ()
{
    $.nette.ext('modals',
    {
        success: function (payload, status, jqXHR, settings)
        {
            var modals = payload.modals;

            if (typeof modals !== 'undefined')
            {
                modals.reverse().forEach(function (modal)
                {
                    var $modal = $(modal.domModalId);

                    if ($modal.length === 0)
                    {
                        throw 'DOM element ' + modal.domModalId + ' does not exists.';
                    }

                    if ($modal.hasClass('wakers_modal'))
                    {
                        // Wakers modal
                        $modal.wakersModal(modal.toggle);
                    }
                    else
                    {
                        // Bootstrap modal
                        $modal.modal(modal.toggle);
                    }
                });
            }
        }
    });

    var openedModals = [];
    var zIndex = 1000;

    $.fn.wakersModal = function (toggle)
    {
        if (this.length !== 0)
        {
            var $self = this;
            var isOpened = parseInt(this.css('right')) === 0;

            if (toggle === 'toggle')
            {
                toggle = isOpened  ? 'hide' : 'show';
            }

            console.log();

            if (toggle === 'show' && isOpened === false)
            {
                this.addClass('modal_open');
                $('body').addClass('wakers_modal_overflow');
                $.overlay(toggle);

                zIndex++;

                this.css('z-index', zIndex);
                //this.find('form:first').not('[data-wakers-nofocus]').find('input:first').focus();

                openedModals.push({
                    element: $self,
                    zIndex: zIndex
                });
            }
            else if (toggle === 'hide' && isOpened === true)
            {
                $.each(openedModals, function (i, value)
                {
                    if (value.zIndex === zIndex)
                    {
                        value.element.removeClass('modal_open');
                        value.element.removeAttr('style');
                        openedModals.splice(i, 1);
                        zIndex--;
                    }
                });

                if (openedModals.length === 0)
                {
                    $('body').removeClass('wakers_modal_overflow');

                    $.overlay(toggle);
                }
            }
        }
    };


    $.overlay = function (toggle)
    {
        var $overlay = $('.wakers_modal_overlay');

        if ($overlay.length === 0 && toggle === 'show')
        {
            $('body').prepend('<div class="wakers_modal_overlay"></div>');

            $overlay.animateCss({
                animationName: 'fadeIn'
            });
        }

        else if ($overlay.length === 1 && toggle === 'hide')
        {
            $overlay.animateCss({
                animationName: 'fadeOut',
                afterAnimate: function ()
                {
                    $overlay.remove();
                }
            });
        }
    };


    $(document).on('click', '[data-wakers-modal-open]', function (event)
    {
        event.preventDefault();

        var modalName = '#' + $(this).data('wakers-modal-open');

        var $targetModal = $(modalName);

        if ($targetModal.length === 0)
        {
            throw 'DOM element ' + modalName + ' does not exists.';
        }

        $targetModal.wakersModal('show');
    });


    $(document).on('click', '.wakers_modal.modal_open [data-wakers-modal-close]', function (event)
    {
        event.preventDefault();

        var $modal = $(this).parents('.wakers_modal.modal_open');

        $modal.wakersModal('hide');
    });


    // Hide modal by ESC
    $(document).keyup(function(e)
    {
        if (e.keyCode === 27)
        {
            $.each(openedModals, function (i, value)
            {
                if (value.zIndex === zIndex)
                {
                    value.element.wakersModal('hide');
                }
            })
        }
    });
});