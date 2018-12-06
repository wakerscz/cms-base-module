<?php
/**
 * Copyright (c) 2018 Wakers.cz
 *
 * @author Jiří Zapletal (http://www.wakers.cz, zapletal@wakers.cz)
 *
 */


namespace Wakers\BaseModule\Component\Common\Notification;


use Nette\DeprecatedException;
use Nette\InvalidArgumentException;


trait Create
{
    /**
     * @var INotification
     * @inject
     */
    public $IBase_Notification;


    /**
     * Use method notification()
     * @deprecated
     */
    public function flashMessage($message, $type = 'info') : void
    {
        throw new DeprecatedException("Deprecated method 'flashMessage()' use 'notification()' method.");
    }


    /**
     * Notifikace pomocí JS (AJAX).
     * @param string $title
     * @param string $message
     * @param string $type
     * @param bool $send_payload
     * @throws
     */
    public function notificationAjax(string $title, string $message, string $type = 'default', bool $send_payload = TRUE): void
    {
        if ($this->isAjax())
        {
            $this->payload->notifications[] = $this->createNotification($title, $message, $type);

            if ($send_payload === TRUE)
            {
                $this->sendPayload();
            }
        }
    }


    /**
     * Klasické notifikace, renderované po redirectu (upravené FlashMessages).
     * @param string $title
     * @param string $message
     * @param string $type
     * @return object
     */
    public function notification(string $title, string $message, string $type = 'default') : object
    {
        $id = $this->getParameterId('flash');
        $messages = $this->getPresenter()->getFlashSession()->$id;

        $messages[] = $flash = (object) $this->createNotification($title, $message, $type);

        $this->getTemplate()->flashes = $messages;
        $this->getPresenter()->getFlashSession()->$id = $messages;

        return $flash;
    }


    /**
     * Metoda pro správné vytvoření notifikace
     * @param string $title
     * @param string $message
     * @param string $type
     * @return array
     */
    protected function createNotification(string $title, string $message, string $type): array
    {
        if (!in_array($type, Notification::TYPES))
        {
            $allowed_types = implode(', ', Notification::TYPES);
            throw new InvalidArgumentException("Wrong notification \$type '{$type}'. Use only '{$allowed_types}' types.");
        }

        return [
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ];
    }


    /**
     * Notifikace (náhrada za flashMessages)
     * @return Notification
     */
    protected function createComponentBaseNotification() : object
    {

        $control = $this->IBase_Notification->create();
        return $control;
    }
}