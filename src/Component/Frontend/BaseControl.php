<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Frontend;


use Nette\Application\UI\Control;
use Wakers\PageModule\Presenter\FrontendPresenter;


/**
 * @property-read FrontendPresenter $presenter
 */
abstract class BaseControl extends Control
{

}