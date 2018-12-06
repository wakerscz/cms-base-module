<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Admin\NavBar;


use Wakers\BaseModule\Component\Admin\BaseControl;
use Wakers\BaseModule\Repository\NavBarRepository;


class NavBar extends BaseControl
{
    /**
     * @var NavBarRepository
     */
    protected $navBarRepository;


    /**
     * NavBar constructor.
     * @param NavBarRepository $navBarRepository
     */
    public function __construct(NavBarRepository $navBarRepository)
    {
        $this->navBarRepository = $navBarRepository;
    }


    /**
     * Render
     */
    public function render() : void
    {
        $this->template->navbarPaths = $this->navBarRepository->getAllPaths();
        $this->template->setFile(__DIR__ . '/templates/navbar.latte');
        $this->template->render();
    }
}