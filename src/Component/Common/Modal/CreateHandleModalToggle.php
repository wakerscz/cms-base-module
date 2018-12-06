<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common\Modal;


use Nette\InvalidArgumentException;
use Wakers\BaseModule\Presenter\BaseAdminPresenter;
use Wakers\PageModule\Presenter\FrontendPresenter;


/**
 * @property-read FrontendPresenter|BaseAdminPresenter $presenter
 */
trait CreateHandleModalToggle
{
    /**
     * Handler - Otevře či zavře modální okno pomocí JS (AJAX).
     *
     * @param string $toggle
     * @param string $domModalId
     * @param bool $sendPayload
     */
    public function handleModalToggle(string $toggle = 'show', string $domModalId = '#my_modal_name', $sendPayload = TRUE) : void
    {
        if($this->isAjax())
        {
            if(!in_array($toggle, Modal::TOGGLE_TYPES))
            {
                $toggleTypes = implode(', ', Modal::TOGGLE_TYPES);
                throw new InvalidArgumentException("Wrong toggle type '{$toggle}'. Use only: '{$toggleTypes}'");
            }

            $this->payload->modals[] = [
                'toggle' => $toggle,
                'domModalId' => $domModalId
            ];

            if ($sendPayload)
            {
                $this->sendPayload();
            }
        }
    }
}