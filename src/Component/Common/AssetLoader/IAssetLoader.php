<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common\AssetLoader;


interface IAssetLoader
{
    /**
     * @return AssetLoader
     */
    public function create() : AssetLoader;
}