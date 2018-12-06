<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Repository;


class DashboardRepository
{
    use \Wakers\BaseModule\Util\GetTemplatePaths;


    /**
     * DashboardRepository constructor.
     * @param array $frontendDashboard
     */
    public function __construct(array $frontendDashboard = NULL)
    {
        $this->paths = $frontendDashboard ? $frontendDashboard : [];
    }
}