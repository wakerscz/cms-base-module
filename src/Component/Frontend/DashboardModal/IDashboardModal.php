<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Frontend\DashboardModal;


interface IDashboardModal
{
    /**
     * @return DashboardModal
     */
    public function create() : DashboardModal;
}