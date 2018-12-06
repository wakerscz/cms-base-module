<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Security;


use Wakers\BaseModule\Builder\AclBuilder\AuthorizatorBuilder;
use Wakers\UserModule\Security\UserAuthorizator;


class BaseAuthorizator extends AuthorizatorBuilder
{
    const
        RES_SITE_MANAGER = 'BASE_RES_SITE_MANAGER',          // Administrační sekce - /site-manager/
        RES_IN_PAGE_MANAGER = 'BASE_RES_IN_PAGE_MANAGER',    // Administrační sekce na Frontendu (horní panely, etc.),
        RES_FOR_REGISTERED = 'BASE_RES_FOR_REGISTERED',      // Obsah pro registrované
        RES_DASHBOARD_MODAL = 'BASE_RES_DASHBOARD_MODAL'     // Dashboard
    ;


    /**
     * @return array
     */
    public function create() : array
    {
        /*
         * Resources
         */

        $this->addResource(self::RES_SITE_MANAGER);
        $this->addResource(self::RES_IN_PAGE_MANAGER);
        $this->addResource(self::RES_FOR_REGISTERED);
        $this->addResource(self::RES_DASHBOARD_MODAL);


        /*
         * Privileges
         */

        // Registrovaný
        $this->allow([
            UserAuthorizator::ROLE_AUTHENTICATED,
            UserAuthorizator::ROLE_EDITOR
        ], [
            self::RES_FOR_REGISTERED,
            self::RES_DASHBOARD_MODAL
        ]);


        // Editor
        $this->allow([
            UserAuthorizator::ROLE_EDITOR
        ], [
            BaseAuthorizator::RES_IN_PAGE_MANAGER,
            BaseAuthorizator::RES_SITE_MANAGER,
        ]);

        return parent::create();
    }
}