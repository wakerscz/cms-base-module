<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common\PermissionWatcher;


use Nette\Application\ForbiddenRequestException;
use Wakers\BaseModule\Presenter\BaseAdminPresenter;
use Wakers\PageModule\Presenter\FrontendPresenter;
use Wakers\UserModule\Database\User;
use Wakers\UserModule\Repository\UserRepository;


/**
 * @property-read BaseAdminPresenter|FrontendPresenter $presenter
 * @property-read \Nette\Security\User $user
 * @property-read UserRepository $userRepository
 */
trait Create
{
    /**
     * @throws ForbiddenRequestException
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function compareIdentityWithDb() : void
    {
        if ($this->user->isLoggedIn())
        {
            $id = $this->user->getId();

            $userEntity = $this->userRepository->findOneByIdJoinRoles($id);

            $logout = FALSE;

            if ($userEntity)
            {
                /** @var array $identityData */
                $identityData = $this->user->getIdentity()->getData();

                /** @var User $sessionEntity */
                $sessionEntity = $identityData['userEntity'];

                $dbRoles = $userEntity->getUserRoles()->getFirst()->getRoleKey();
                $sessionRoles = $identityData['roles']->getFirst()->getRoleKey();

                $logout = !($dbRoles !== $sessionRoles || $userEntity->getStatus() !== $sessionEntity->getStatus());
            }

            if (!($logout || !$userEntity))
            {
                $this->user->logout(TRUE);

                $this->notification(
                    'Odhlášení',
                    'Vaše oprávněná byla upravena, pokuste se přihlásit znovu.',
                    'warning'
                );

                $this->redirect($this instanceof FrontendPresenter ? 'this' : ':User:Admin:Login');
                throw new ForbiddenRequestException;
            }
        }
    }
}