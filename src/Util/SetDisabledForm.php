<?php
/**
 * Copyright (c) 2019 Wakers.cz
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 */


namespace Wakers\BaseModule\Util;


use Nette\Application\UI\Form;


trait SetDisabledForm
{
    /**
     * Nastaví disabled na prvky formuláře
     * @param Form $form
     * @param bool $disabled
     */
    protected function setDisabledForm(Form $form, bool $disabled = TRUE) : void
    {
        foreach ($form->getComponents() as $component)
        {
            $component->setDisabled($disabled);
        }
    }
}