<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Admin\NavBar;


use Wakers\BaseModule\Presenter\BaseAdminPresenter;


/**
 * @property-read BaseAdminPresenter $presenter
 */
trait Create
{
    /**
     * @var INavBar
     * @inject
     */
    public $IBase_NavBar;


    /**
     * Zobrazuje hlavní navigační menu
     * @return NavBar
     */
    protected function createComponentBaseNavBar() : object
    {
        return $this->IBase_NavBar->create();
    }
}