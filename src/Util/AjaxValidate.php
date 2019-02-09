<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Util;


use Nette\Application\UI\Form;
use Wakers\BaseModule\Presenter\BaseAdminPresenter;
use Wakers\PageModule\Presenter\FrontendPresenter;


/**
 * @property-read BaseAdminPresenter|FrontendPresenter $presenter
 */
trait AjaxValidate
{
    /**
     * Validace formuláře - pouze AJAXem.
     * @param Form $form
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function validate(Form $form) : void
    {
        if ($this->presenter->isAjax())
        {
            foreach ($form->getErrors() as $error)
            {
                $this->presenter->notificationAjax(
                    $this->presenter->translate->translate('Error'),
                    $error,
                    'error'
                );
            }
        }
    }
}