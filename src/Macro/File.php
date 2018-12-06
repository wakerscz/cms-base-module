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


class File extends UIMacros
{
    /**
     * @param Compiler $compiler
     */
    public static function install(Compiler $compiler)
    {
        $set = new static($compiler);
        $set->addMacro('file', [$set, 'classicMacroFile'], NULL, NULL);
    }
    

    /**
     * Použití:
     *  {file $absPrivateSplFile}
     *
     * @param MacroNode $node
     * @param PhpWriter $writer
     * @return string
     */
    public function classicMacroFile(MacroNode $node, PhpWriter $writer)
    {
        return $writer->write('   
              $wakers_file = %node.array;
              echo LR\Filters::escapeHtmlText($baseUrl);
              echo ($wakers_file[0])->getPublicFile();
        ');
    }
}