<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Macro;


use Latte\Compiler;
use Latte\MacroNode;
use Latte\PhpWriter;
use Nette\Bridges\ApplicationLatte\UIMacros;


class Image extends UIMacros
{
    /**
     * @param Compiler $compiler
     */
    public static function install(Compiler $compiler)
    {
        $set = new static($compiler);
        $set->addMacro('img', [$set, 'classicMacroImg'], NULL, NULL);
    }

    /**
     * Použití:
     *  {img $absPrivateSplFile, $size, $cropType}
     *  {img $absPrivateSplFile, 1440x900, 'SHRINK_ONLY'}
     *
     * @param MacroNode $node
     * @param PhpWriter $writer
     * @return string
     */
    public function classicMacroImg(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write('   
              $wakers_img = %node.array;
              echo LR\Filters::escapeHtmlText($baseUrl);
              echo ($wakers_img[0])->getPublicImage($wakers_img[1], $wakers_img[2]);
        ');
    }
}