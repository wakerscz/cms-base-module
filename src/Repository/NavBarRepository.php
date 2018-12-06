<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Repository;


use Wakers\BaseModule\Util\GetTemplatePaths;


class NavBarRepository
{
    use GetTemplatePaths;


    /**
     * NavBarRepository constructor.
     * @param array $adminNavBar
     */
    public function __construct(array $adminNavBar = NULL)
    {
        $this->paths = $adminNavBar ? $adminNavBar : [];
    }
}