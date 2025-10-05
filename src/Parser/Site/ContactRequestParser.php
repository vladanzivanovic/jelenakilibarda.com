<?php

declare(strict_types=1);

namespace App\Parser\Site;

use Symfony\Component\HttpFoundation\ParameterBag;

final class ContactRequestParser
{
    /**
     * @return array
     * @throws \Exception
     */
    public function parse(ParameterBag $bag): array
    {
        return [
            'firstName' => $bag->get('first_name'),
            'lastName' => $bag->get('last_name'),
            'contactEmail' => $bag->get('email'),
            'note' => $bag->get('note'),
        ];
    }
}
