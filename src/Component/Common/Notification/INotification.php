<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common\Notification;


interface INotification
{
    /**
     * @return Notification
     */
    public function create() : Notification;
}