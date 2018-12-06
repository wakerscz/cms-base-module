<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Presenter;


use Nette;


class Error4xxPresenter extends Nette\Application\UI\Presenter
{
    /**
     * @throws Nette\Application\BadRequestException
     */
	public function startup() : void
	{
		parent::startup();

		if (!$this->getRequest()->isMethod(Nette\Application\Request::FORWARD))
		{
			$this->error();
		}
	}


    /**
     * @param Nette\Application\BadRequestException $exception
     */
	public function renderDefault(Nette\Application\BadRequestException $exception) : void
	{
	    $this->setLayout(__DIR__ . '/templates/@error.latte');
		// load template 403.latte or 404.latte or ... 4xx.latte
		$file = __DIR__ . "/templates/Error/{$exception->getCode()}.latte";
		$this->template->setFile(is_file($file) ? $file : __DIR__ . '/templates/Error/4xx.latte');
	}
}
