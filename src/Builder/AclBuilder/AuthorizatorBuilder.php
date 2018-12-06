<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */

namespace Wakers\BaseModule\Builder\AclBuilder;


use Nette\Security\Permission;

abstract class AuthorizatorBuilder
{
    /**
     * @var array
     */
    private $configuration = [];


    /**
     * @param $role
     * @param null $parents
     * @return AuthorizatorBuilder
     */
    public function addRole($role, $parents = null) : AuthorizatorBuilder
    {
        $this->configuration[] = [
            'method' => $this->removeNamespace(__METHOD__),
            'params' => func_get_args()
        ];

        return $this;
    }


    /**
     * @param $resource
     * @param null $parent
     * @return AuthorizatorBuilder
     */
    public function addResource($resource, $parent = null) : AuthorizatorBuilder
    {
        $this->configuration[] = [
            'method' => $this->removeNamespace(__METHOD__),
            'params' => func_get_args()
        ];

        return $this;
    }


    /**
     * @param null $roles
     * @param null $resources
     * @param null $privileges
     * @param null $assertion
     * @return AuthorizatorBuilder
     */
    public function allow($roles = Permission::ALL, $resources = Permission::ALL, $privileges = Permission::ALL, $assertion = NULL): AuthorizatorBuilder
    {
        $this->configuration[] = [
            'method' => $this->removeNamespace(__METHOD__),
            'params' => func_get_args()
        ];

        return $this;
    }


    /**
     * @param null $roles
     * @param null $resources
     * @param null $privileges
     * @param null $assertion
     * @return AuthorizatorBuilder
     */
    public function deny($roles = Permission::ALL, $resources = Permission::ALL, $privileges = Permission::ALL, $assertion = NULL) : AuthorizatorBuilder
    {
        $this->configuration[] = [
            'method' => $this->removeNamespace(__METHOD__),
            'params' => func_get_args()
        ];

        return $this;
    }


    /**
     * @return array
     */
    protected function create() : array
    {
        return $this->configuration;
    }


    /**
     * @param string $methodName
     * @return string
     */
    private function removeNamespace(string $methodName) : string
    {
        return str_replace(__CLASS__ . '::', '', $methodName);
    }

}