<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common\Notification;


use Nette\Bridges\ApplicationLatte\Template;
use Wakers\BaseModule\Component\Common\BaseControl;


/**
 * @property Template $template
 */
class Notification extends BaseControl
{
    const TYPES = [
        'success',
        'error',
        'warning',
        'default',
        'info'
    ];


    /**
     * Render
     */
    public function render() : void
    {
        $this->template->setFile(__DIR__ . '/templates/notification.latte');
        $this->template->render();
    }
}