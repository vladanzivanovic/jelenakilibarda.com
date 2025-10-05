<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Tags;
use App\Helper\ValidatorHelper;
use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class TagHandler
{
    /**
     * @var TagsRepository
     */
    private $tagsRepository;
    /**
     * @var ValidatorHelper
     */
    private $validator;

    /**
     * TagHandler constructor.
     *
     * @param TagsRepository  $tagsRepository
     * @param ValidatorHelper $validator
     */
    public function __construct(
        TagsRepository $tagsRepository,
        ValidatorHelper $validator
    ) {
        $this->tagsRepository = $tagsRepository;
        $this->validator = $validator;
    }

    /**
     * @param Tags $tags
     * @param bool $isEdit
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Tags $tags): void
    {
        $errors = $this->validator->validate($tags, null, "SetTag");

        if ($errors->count() > 0) {
            throw new UnprocessableEntityHttpException(json_encode($this->validator->parseErrors($errors)));
        }

        if (null === $tags->getId()) {
            $this->tagsRepository->persist($tags);
        }

        $this->tagsRepository->flush();
    }

    /**
     * @param Tags $tags
     *
     * @return void
     */
    public function remove(Tags $tags): void
    {
        $this->tagsRepository->delete($tags);

        $this->tagsRepository->flush();
    }
}