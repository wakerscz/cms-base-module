/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

$(function ()
{
    $(document).on('click', '.wakers_dashboard_handle', function ()
    {
        $('#wakers_base_dashboard_modal').wakersModal('show');
    });
});