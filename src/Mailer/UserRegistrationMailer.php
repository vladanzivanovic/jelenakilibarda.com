<?php

declare(strict_types=1);

namespace App\Mailer;

use App\Entity\User;
use App\Event\EmailEvent;
use App\Helper\SettingsHelper;
use App\Model\EmailModel;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class UserRegistrationMailer
{
    private EventDispatcherInterface $dispatcher;

    private SettingsHelper $settingsHelper;

    private TranslatorInterface $translator;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        SettingsHelper $settingsHelper,
        TranslatorInterface $translator
    ) {
        $this->dispatcher = $dispatcher;
        $this->settingsHelper = $settingsHelper;
        $this->translator = $translator;
    }

    public function sendEmail(User $user, string $locale)
    {
        $emailModelCustomer = $this->prepareEmail($user, $locale);
        $event = new EmailEvent($emailModelCustomer);
        $this->dispatcher->dispatch($event, EmailEvent::SEND_EMAIL);
    }

    /**
     * @param User   $user
     * @param string $locale
     *
     * @return EmailModel
     */
    private function prepareEmail(User $user, string $locale): EmailModel
    {
        $settings = $this->settingsHelper->getSettings();

        $model = new EmailModel();
        $model->setScript(EmailModel::SCRIPT_USER_REGISTRATION);
        $model->setTemplate('registration');
        $model->setTo($user->getEmail());
        $model->setToName($user->getFirstName().' '.$user->getLastName());
        $model->setSubject($this->translator->trans('email.registration.title', ['%siteName%' => $settings['SITE_NAME']]));
        $model->setFrom($settings['MAIN_EMAIL']);
        $model->setFromName($settings['SITE_NAME']);
        $model->setReplyTo($settings['MAIN_EMAIL']);
        $model->setReplyToName($settings['SITE_NAME']);
        $model->setTemplateData([
            'locale' => $locale,
            'token' => $user->getResetToken(),
            'siteName' => $settings['SITE_NAME'],
        ]);

        return $model;
    }
}