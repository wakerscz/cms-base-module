<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author David Kolář
 *
 */


namespace Wakers\BaseModule\Component\Admin\BreadCrumb;


use Wakers\BaseModule\Component\Admin\BaseControl;


class BreadCrumb extends BaseControl
{
    /**
     * Render
     * @param array $breadcrumb
     * @throws \Nette\Application\UI\InvalidLinkException
     */
    public function render(array $breadcrumb) : void
    {
        $admin = ['link' => ':Base:Admin:Dashboard', 'title' => 'Admin'];

        if ($this->presenter->isLinkCurrent(':Base:Admin:Dashboard'))
        {
            $admin = ['title' => 'Admin'];
        }

        array_unshift($breadcrumb, $admin);

        $this->template->breadcrumb = $breadcrumb;

        $this->template->setFile(__DIR__ . '/templates/breadcrumb.latte');
        $this->template->render();
    }
}