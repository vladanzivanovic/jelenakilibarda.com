<?php

namespace App\EventListener;

use App\Entity\Email;
use App\Event\EmailEvent;
use App\Helper\RandomCodeGenerator;
use App\Model\EmailModel;
use App\Repository\EmailRepository;
use App\Repository\SettingsRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final class EmailSubscriber implements EventSubscriberInterface
{
    private RandomCodeGenerator $codeGenerator;

    private MailerInterface $mailer;

    private EmailRepository $emailRepository;

    private string $siteUrl;

    public function __construct(
        RandomCodeGenerator $codeGenerator,
        MailerInterface $mailer,
        EmailRepository $emailRepository,
        string $siteUrl
    ) {
        $this->codeGenerator = $codeGenerator;
        $this->mailer = $mailer;
        $this->emailRepository = $emailRepository;
        $this->siteUrl = $siteUrl;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
       return [
           EmailEvent::SEND_EMAIL => [
               ['setAndSendEmail', 0],
           ],
       ];
    }

    /**
     * @param EmailModel $emailModel
     *
     * @throws \Swift_SwiftException
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @throws \Doctrine\ORM\ORMException
     */
    public function setAndSendEmail(EmailEvent $event): void
    {
        $emailModel = $event->getEmailModel();
        $templateData = $emailModel->getTemplateData();
        $templateData['code'] = $this->codeGenerator->random();

        $emailModel->setCode($templateData['code']);


        if (false === $emailModel->hasSubject()) {
            $emailModel->setSubject('Poruka sa sajta '.$this->siteUrl);
        }

        $this->send($emailModel);
    }

    /**
     * @param EmailModel $emailModel
     *
     * @throws \Swift_SwiftException
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     * @throws \Doctrine\ORM\ORMException
     */
    private function send(EmailModel $emailModel): void
    {
        try {
            $emailInstance = (new TemplatedEmail())
                ->subject($emailModel->getSubject())
                ->from(new Address($emailModel->getFrom(), $emailModel->getFromName()))
                ->replyTo(new Address($emailModel->getReplyTo(), $emailModel->getReplyToName()))
                ->to(new Address($emailModel->getTo(), $emailModel->getToName()))
                ->htmlTemplate('Site/Email/'.$emailModel->getTemplate())
                ->context($emailModel->getTemplateData());

            if (!empty($emailModel->getAttachments())) {
                foreach ($emailModel->getAttachments() as $attachment) {
                    $emailInstance->attach(( new \Swift_Attachment())->setFile($attachment));
                }
            }

            $this->mailer->send($emailInstance);
            $emailModel->setStatus(Email::EMAIL_SUCCESS);
            $this->saveEmail($emailModel);

        } catch (TransportExceptionInterface $transportException){

            $emailModel->setStatus(Email::EMAIL_FAILED);
            $emailModel->setErrorMsg($transportException->getMessage());
            $this->saveEmail($emailModel);
            throw new TransportException(Email::EMAIL_FAILED);
        }
    }

    /**
     * @param EmailModel $emailModel
     *
     * @throws \Doctrine\ORM\ORMException
     */
    private function saveEmail(EmailModel $emailModel): void
    {
        $email = new Email();

        $email->setFromemail($emailModel->getReplyTo() ?? $emailModel->getFrom());
        $email->setToemail($emailModel->getTo());
        $email->setRawdata(json_encode($emailModel->_toArray()));
        $email->setStatus($emailModel->getStatus());
        $email->setErrormessage($emailModel->getErrorMsg());
        $email->setScript($emailModel->getScript());
        $email->setCode($emailModel->getCode());

        $this->emailRepository->persist($email);
        $this->emailRepository->flush();
    }
}
