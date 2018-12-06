<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common;


use Nette\Application\UI\Control;
use Wakers\BaseModule\Presenter\BaseAdminPresenter;
use Wakers\PageModule\Presenter\FrontendPresenter;


/**
 * @property-read BaseAdminPresenter|FrontendPresenter $presenter
 */
abstract class BaseControl extends Control
{

}