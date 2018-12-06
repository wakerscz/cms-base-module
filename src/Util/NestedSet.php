<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 * @author David Kolář
 *
 */


namespace Wakers\BaseModule\Util;


use Nette\Utils\DateTime;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;


/**
 * Třída pro práci s nested-setem v Propel ORM.
 *
 * Umožňuje seřatit položky stromu na jednotlivých úrovních podle zadaného kritéria.
 * Používá se pouze v případě, že máme v tabulce více stromů a ty nemají společného předka (parent item).
 *
 * @package Wakers\UtilModule\Tool
 */
class NestedSet
{
    /**
     * Název DB sloupce
     * @var string
     */
    protected $orderBy;


    /**
     * Criteria řazení (ASC / DESC)
     * @var string
     */
    protected $criteria;


    /**
     * Mázev metody vracející záznám v buňce DB tabulky
     * @var string
     */
    protected $getterName;


    /**
     * PropelNestedSet constructor.
     * @param string $orderBy
     * @param string $criteria
     */
    public function
    __construct(string $orderBy, string $criteria = Criteria::ASC)
    {
        $this->orderBy = $orderBy;
        $this->criteria = $criteria;

        $this->getterName = 'get' . ucfirst($this->orderBy);
    }


    /**
     * Metoda pro transformaci nested tree do multilevel pole
     * @param ObjectCollection $objectCollection
     * @param int $left
     * @param int|NULL $right
     * @return array
     */
    public function getTree(ObjectCollection $objectCollection, int $left = 0, int $right = NULL) : array
    {
        $items = [];

        foreach ($objectCollection as $item)
        {
            $items[] = $item;
        }

        $tree =  $this->generateTree($items, $left, $right);

        return $tree;
    }


    /**
     * Metoda pro transformaci multilevel pole do flat ObjectCollection
     * @param array $tree
     * @return ObjectCollection
     */
    public function getFlatCollection(array $tree) : ObjectCollection
    {
        $data = [];

        array_walk_recursive($tree, function ($item) use (&$data)
        {
            if ($item !== NULL)
            {
                $data[] = $item;
            }
        });

        return new ObjectCollection($data);
    }


    /**
     * Rekurzivní metoda pro transformaci nested tree do multilevel pole
     * https://stackoverflow.com/questions/16999530/how-do-i-format-nested-set-model-data-into-an-array
     * @param array $items
     * @param int $left
     * @param int|NULL $right
     * @return array
     */
    protected function generateTree(array $items, int $left = 0, int $right = NULL) : array
    {
        $tree = [];

        // Prochází jednotlivé položky a transformuje je do multilevel pole
        foreach ($items as $item)
        {
            if ($item->getLeftValue() === $left + 1 && ($right === NULL || $item->getRightValue() < $right))
            {
                $tree[] = [
                    'item' => $item,
                    'descendants' => self::generateTree($items, $item->getLeftValue(), $item->getRightValue())
                ];

                $left = $item->getRightValue();
            }
        }

        // Seřadí
        $tree = $this->sort($tree);

        return $tree;
    }


    /**
     * Seřadí položky na konkrétní úrovni stromu
     * @param array $items
     * @return array
     */
    protected function sort(array $items) : array
    {
        if (count($items) > 1)
        {
            usort($items, function(&$a, &$b)
            {
                $getterName = $this->getterName;

                $compare = mb_strtolower($a['item']->$getterName()) > mb_strtolower($b['item']->$getterName());

                if ($this->criteria === Criteria::ASC)
                {
                    return $compare;
                }

                return !$compare;
            });
        }

        return $items;
    }

}