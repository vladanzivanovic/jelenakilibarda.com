<?php

declare(strict_types=1);

namespace App\Handler\Site;

use App\Entity\User;
use App\Helper\ValidatorHelper;
use App\Mailer\UserRegistrationMailer;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserHandler
{
    private ValidatorHelper $validator;

    private UserRepository $userRepository;

    private UserPasswordEncoderInterface $passwordEncoder;

    private UserRegistrationMailer $userRegistrationMailer;

    public function __construct(
        ValidatorHelper $validator,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRegistrationMailer $userRegistrationMailer
    ) {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->userRegistrationMailer = $userRegistrationMailer;
    }

    /**
     * @param User   $user
     * @param string $locale
     * @param string $group
     * @param bool   $shouldSendEmail
     * @param bool   $shouldUpdatePassword
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(User $user, string $locale, ?string $group = null, bool $shouldSendEmail = false, $shouldUpdatePassword = false): void
    {
        if (null !== $group) {
            $errors = $this->validator->validate($user, null, $group);

            if ($errors->count() > 0) {
                throw new BadRequestHttpException(json_encode($this->validator->parseErrors($errors)));
            }
        }

        if (true === $shouldUpdatePassword) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
        }

        if (null == $user->getId()) {
            $this->userRepository->persist($user);
        }

        $this->userRepository->flush();

        if (true === $shouldSendEmail) {
            $this->userRegistrationMailer->sendEmail($user, $locale);
        }
    }
}