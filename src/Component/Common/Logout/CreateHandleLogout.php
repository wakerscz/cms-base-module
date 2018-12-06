<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common\Logout;


use Nette\Security\User;
use Wakers\BaseModule\Presenter\BaseAdminPresenter;
use Wakers\LangModule\Translator\Translate;
use Wakers\PageModule\Presenter\FrontendPresenter;


/**
 * @property-read BaseAdminPresenter
 * @property-read FrontendPresenter
 * @property-read User $user
 * @property-read Translate $translate
 */
trait CreateHandleLogout
{
    /**
     * Handler - Odhlášení
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function handleLogout() : void
    {
        if ($this->user->isLoggedIn())
        {
            $this->user->logout(TRUE);

            $this->notification(
                $this->translate->translate('Logout'),
                $this->translate->translate('You have successfully logged out.'),
                'success'
            );

            $this->redirect($this instanceof FrontendPresenter ? 'this' : ':User:Admin:Login');
        }
    }
}