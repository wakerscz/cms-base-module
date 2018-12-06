<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Database;


use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Propel;


abstract class AbstractDatabase
{
    /**
     * @var \Propel\Runtime\Connection\ConnectionInterface
     */
    private $connection;


    /**
     * Vrací instanci defaultního připojení
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        if ($this->connection instanceof ConnectionInterface === FALSE)
        {
            $this->connection = Propel::getConnection();
        }

        return $this->connection;
    }
}