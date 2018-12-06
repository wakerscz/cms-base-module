<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Frontend\DashboardModal;


trait Create
{
    /**
     * @var IDashboardModal
     * @inject
     */
    public $IBase_DashboardModal;


    /**
     * Dashboard Modal
     * @return DashboardModal
     */
    protected function createComponentBaseDashboardModal() : object
    {
        return $this->IBase_DashboardModal->create();
    }
}