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
use Wakers\PageModule\Presenter\FrontendPresenter;


/**
 * @property-read BaseAdminPresenter
 * @property-read FrontendPresenter
 * @property-read User $user
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
                'Odhlášení',
                'Byli jste úspěšně odhlášeni.',
                'success'
            );

            $this->redirect($this instanceof FrontendPresenter ? 'this' : ':User:Admin:Login');
        }
    }
}