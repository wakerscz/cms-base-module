<?php
/**
 * Author: Jiří Zapletal
 * Company: Wakers (http://www.wakers.cz)
 * Contact: zapletal@wakers.cz
 * Copyright 2017
 */

namespace Wakers\BaseModule\Router;


use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;
use Wakers\PageModule\Repository\PageRepository;


class RouterFactory
{
    /**
     * @var PageRepository
     */
	protected $pageRepository;


    /**
     * @var array
     */
	protected $adminModules;


    /**
     * RouterFactory constructor.
     * @param array $adminModules
     * @param PageRepository $pageRepository
     */
	public function __construct(array $adminModules, PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->adminModules = $adminModules;
    }


    /**
     * @return RouteList
     */
	public function createRouter()
	{
        $modules = implode('|', $this->adminModules);

	    $router = new RouteList;

	    if (php_sapi_name() !== 'cli')
        {
            // Routa pro externí administraci
            $router[] = new Route("/site-manager/<module ({$modules})>/<presenter>/<action>[/<id [\d]{1,}>]", [
                'module' => 'User',
                'presenter' => 'Admin',
                'action' => 'Login'
            ]);


            // Routa pro frontend
            $router[] = new Route("/[<url .*>][/pg-<pagination ([2-9]{1}[0-9]*)>]", [
                'module' => 'App',
                'presenter' => 'Run',
                'action' => 'setUrl'
            ]);
        }

		return $router;
	}

}