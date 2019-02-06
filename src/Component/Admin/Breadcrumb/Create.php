<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author David Kolář
 *
 */


namespace Wakers\BaseModule\Component\Admin\BreadCrumb;


trait Create
{
    /**
     * @var IBreadCrumb
     * @inject
     */
    public $IBase_BreadCrumb;


    /**
     * Komponenta pro zobrazení cestičky
     * @return BreadCrumb
     */
    protected function createComponentBaseBreadCrumb() : object
    {
        return $this->IBase_BreadCrumb->create();
    }
}