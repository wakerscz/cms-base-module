<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Presenter;


use Nette\Application\ForbiddenRequestException;
use Nette\Application\UI\Presenter;
use Wakers\BaseModule\Security\BaseAuthorizator;
use Wakers\LangModule\Repository\LangRepository;
use Wakers\LangModule\Translator\Translate;
use Wakers\UserModule\Repository\UserRepository;


abstract class BaseAdminPresenter extends Presenter
{
    use \Wakers\BaseModule\Component\Common\PermissionWatcher\Create;
    use \Wakers\BaseModule\Component\Common\AssetLoader\Create;
    use \Wakers\BaseModule\Component\Common\Notification\Create;
    use \Wakers\BaseModule\Component\Common\Modal\CreateHandleModalToggle;
    use \Wakers\BaseModule\Component\Common\Logout\CreateHandleLogout;
    use \Wakers\BaseModule\Component\Admin\NavBar\Create;
    use \Wakers\BaseModule\Component\Admin\BreadCrumb\Create;


    /**
     * @var UserRepository
     * @inject
     */
    public $userRepository;


    /**
     * @var LangRepository
     * @inject
     */
    public $langRepository;


    /**
     * @var Translate
     * @inject
     */
    public $translate;


    /**
     * @throws ForbiddenRequestException
     * @throws \Nette\Application\AbortException
     * @throws \Nette\Application\UI\InvalidLinkException
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Exception
     */
    public function startup() : void
    {
        parent::startup();

        // Defaultní jazyk administrace
        $lang = $this->langRepository->getAdminLang();
        $this->langRepository->setActiveLang($lang);

        // Výchozí layout
        $this->setLayout(__DIR__ . '/templates/@layout.latte');

        // Oprávnění
        $isAllowed = $this->user->isAllowed(BaseAuthorizator::RES_SITE_MANAGER);

        if($this->isLinkCurrent(':User:Admin:Login') === FALSE && $isAllowed === FALSE)
        {
            $this->notification(
                $this->translate->translate('Access denied'),
                $this->translate->translate('Please login to access the administration.'),
                'warning'
            );

            $this->redirect(':User:Admin:Login');

            throw new ForbiddenRequestException;
        }

        // Porovníní identity s DB
        $this->compareIdentityWithDb();
    }
}