<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author David Kolář
 *
 */


namespace Wakers\BaseModule\Component\Admin\BreadCrumb;


interface IBreadCrumb
{
    /**
     * @return BreadCrumb
     */
    public function create() : BreadCrumb;
}