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
     * @var IBreadcrumb
     * @inject
     */
    public $IBase_Breadcrumb;


    /**
     * Komponenta pro zobrazení cestičky
     * @return Breadcrumb
     */
    protected function createComponentBaseBreadcrumb() : object
    {
        return $this->IBase_Breadcrumb->create();
    }
}