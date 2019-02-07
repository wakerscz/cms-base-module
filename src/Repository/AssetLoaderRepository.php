<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Repository;


use Nette\FileNotFoundException;
use Nette\Utils\Json;
use Nette\Utils\Strings;


class AssetLoaderRepository
{
    /**
     * Absolitní cesta ke složce s minifikovanými assets
     */
    const ASSETS_ABS_PATH = __DIR__ . '/../../../../../www/temp/static/';


    /**
     * Relativní cesty
     */
    const
        REL_CSS_PATH = 'temp/static/css/',
        REL_JS_PATH = 'temp/static/js/';


    /**
     * @return array
     * @throws \Nette\Utils\JsonException
     */
    public function getAssetRelPaths() : array
    {
        $files = [];
        $manifestPath = self::ASSETS_ABS_PATH . 'manifest.json';

        if (!file_exists($manifestPath))
        {
            throw new FileNotFoundException("Manifest file not found in {$manifestPath}.");
        }

        $manifest = Json::decode(file_get_contents('nette.safe://' . $manifestPath), Json::FORCE_ARRAY);

        foreach ($manifest as $key => $item)
        {
            $file = new \SplFileInfo(self::ASSETS_ABS_PATH . $item);
            $files[$key] = $file->getFilename();
        }

        return [
            'css' => [
                'inPageManager' => self::REL_CSS_PATH . $files['sys-inpage-manager-build.css'],
                'siteManager' => self::REL_CSS_PATH . $files['sys-site-manager-build.css'],
                'frontend' => self::REL_CSS_PATH . $files['sys-frontend-build.css']
            ],

            'js' => [
                'inPageManager' => self::REL_JS_PATH . $files['sys-inpage-manager-build.js'],
                'siteManager' => self::REL_JS_PATH . $files['sys-site-manager-build.js'],
                'frontend' => self::REL_JS_PATH . $files['sys-frontend-build.js']
            ]
        ];
    }
}