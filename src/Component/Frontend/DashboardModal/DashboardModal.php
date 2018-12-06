<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Frontend\DashboardModal;


use Wakers\BaseModule\Component\Frontend\BaseControl;
use Wakers\BaseModule\Repository\DashboardRepository;


class DashboardModal extends BaseControl
{
    /**
     * @var DashboardRepository
     */
    protected $dashboardRepository;


    /**
     * DashboardModal constructor.
     * @param DashboardRepository $dashboardRepository
     */
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }


    /**
     * Render
     */
    public function render() : void
    {
        $this->template->dashboardPaths = $this->dashboardRepository->getAllPaths();
        $this->template->setFile(__DIR__ . '/templates/dashboardModal.latte');
        $this->template->render();
    }
}