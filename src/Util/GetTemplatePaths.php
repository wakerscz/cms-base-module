<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Util;


use Nette\FileNotFoundException;


trait GetTemplatePaths
{
    /**
     * @var array
     */
    protected $paths = [];


    /**
     * Vrací cesty k souborům jednotlivých šablon (DashboardModal a NavBarModal)
     * @return \SplFileInfo[]
     */
    public function getAllPaths()
    {
        $paths = [];

        foreach ($this->paths as $path)
        {
            $file = __DIR__ . '/../../../' . $path;

            if (!file_exists($file) || is_dir($file))
            {
                throw new FileNotFoundException("File '{$file}' not found.");
            }

            $paths[] = new \SplFileInfo($file);
        }

        return $paths;
    }
}