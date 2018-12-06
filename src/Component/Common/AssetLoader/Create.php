<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common\AssetLoader;


use Wakers\BaseModule\Presenter\BaseAdminPresenter;
use Wakers\PageModule\Presenter\FrontendPresenter;


/**
 * @property-read FrontendPresenter
 * @property-read BaseAdminPresenter
 */
trait Create
{
    /**
     * @var IAssetLoader
     * @inject
     */
    public $IBase_AssetLoader;


    /**
     * Načítá zkompilované CSS a JS do šablony.
     * @return AssetLoader
     */
    protected function createComponentBaseAssetLoader() : object
    {
        return $this->IBase_AssetLoader->create();
    }
}