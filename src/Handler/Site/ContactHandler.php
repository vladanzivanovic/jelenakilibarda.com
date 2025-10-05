<?php

declare(strict_types=1);

namespace App\Handler\Site;

use App\Event\EmailEvent;
use App\Model\EmailModel;
use App\Repository\SettingsRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class ContactHandler
{
    private SettingsRepository $settingsRepository;

    private EventDispatcherInterface $dispatcher;

    public function __construct(
        SettingsRepository $settingsRepository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->settingsRepository = $settingsRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \ReflectionException
     */
    public function save(array $contactData): void
    {
        $askUsEmail = $this->prepareEmail($contactData);
        $event = new EmailEvent($askUsEmail);
        $this->dispatcher->dispatch($event, EmailEvent::SEND_EMAIL);
    }

    /**
     * @param AskUs $askUs
     *
     * @return EmailModel
     */
    private function prepareEmail(array $data): EmailModel
    {
        $settings = $this->getSettings();

        $model = new EmailModel();
        $model->setScript(EmailModel::SCRIPT_CONTACT_US);
        $model->setTemplate('contact');
        $model->setTo($settings['MAIN_EMAIL']);
        $model->setToName($settings['SITE_NAME']);
        $model->setFrom($settings['MAIN_EMAIL']);
        $model->setFromName($settings['SITE_NAME']);
        $model->setReplyTo($data['contactEmail']);
        $model->setReplyToName($data['firstName'].' '.$data['lastName']);
        $model->setTemplateData($data);

        return $model;
    }

    /**
     * @return array
     */
    private function getSettings(): array
    {
        $settings = $this->settingsRepository->getSettingsForOrderEmail();
        $formatted = [];

        foreach ($settings as $setting) {
            $formatted[$setting['slug']] = $setting['value'];
        }

        return $formatted;
    }
}
