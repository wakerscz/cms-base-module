<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common\AssetLoader;


use Wakers\BaseModule\Component\Common\BaseControl;
use Wakers\BaseModule\Repository\AssetLoaderRepository;


class AssetLoader extends BaseControl
{
    /**
     * @var AssetLoaderRepository
     */
    protected $assetLoaderRepository;


    /**
     * @var array
     */
    protected $assets;


    /**
     * AssetLoaderComponent constructor.
     * @param AssetLoaderRepository $assetLoaderRepository
     */
    public function __construct(AssetLoaderRepository $assetLoaderRepository)
    {
        $this->assetLoaderRepository = $assetLoaderRepository;
    }


    /**
     * Načítá zkompilované CSS a JS pomocí souboru assets.json
     *
     * @param string $template
     * @param string $module
     * @throws \Nette\Utils\JsonException
     */
    public function render(string $template, string $module = 'frontend') : void
    {
        if (!$this->assets)
        {
            $this->assets = $this->assetLoaderRepository->getAssetRelPaths();
        }

        $this->template->module = $module;
        $this->template->assets = $this->assets;

        $this->template->setFile(__DIR__ . '/templates/' . $template);
        $this->template->render();
    }
}