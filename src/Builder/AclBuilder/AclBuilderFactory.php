<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

namespace Wakers\BaseModule\Builder\AclBuilder;

use Nette\Security\IAuthorizator;
use Nette\Security\Permission;


class AclBuilderFactory
{
    /**
     * @param array $acl
     * @return IAuthorizator
     */
    public static function build(array $acl) : IAuthorizator
    {
        $permissionArray = [
            'addRole' => [],
            'addResource' => [],
            'allow' => [],
            'denny' => [],
        ];

        foreach($acl as $class)
        {
            $fakeAcl = (new $class)->create();

            foreach ($fakeAcl as $value)
            {
                $permissionArray[$value['method']][] = $value['params'];
            }

        }

        $permission = new Permission;

        foreach ($permissionArray['addRole'] as $params)
        {
            $permission->addRole(...$params);
        }

        foreach ($permissionArray['addResource'] as $params)
        {
            $permission->addResource(...$params);
        }

        foreach ($permissionArray['allow'] as $params)
        {
            $permission->allow(...$params);
        }

        foreach ($permissionArray['denny'] as $params)
        {
            $permission->deny(...$params);
        }


        return $permission;
    }
}