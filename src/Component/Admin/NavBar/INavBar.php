<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Admin\NavBar;


interface INavBar
{
    /**
     * @return NavBar
     */
    public function create() : NavBar;
}