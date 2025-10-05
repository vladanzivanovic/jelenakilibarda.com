<?php

namespace App\Parser;

use App\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

interface RequestParserInterface
{
    public function parse(ParameterBag $bag, EntityInterface $entity = null): EntityInterface;

    public function create(): EntityInterface;
}
