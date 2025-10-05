<?php

declare(strict_types=1);

namespace App\Formatter\Admin;

use Symfony\Component\Routing\RouterInterface;

trait ImageTrait
{
    /**
     * @param RouterInterface $router
     * @param array           $images
     * @param string          $entity
     * @param string          $filter
     *
     * @return array
     */
    private function imagesFormatter(RouterInterface $router, array $images, string $entity, string $filter = 'tmp_image_thumb'): array
    {
         return array_map(function ($image) use ($router, $entity, $filter) {
            $image['file'] = $router->generate('app.image_show', ['entity' => $entity, 'name' => $image['fileName'], 'filter' => $filter]);

            return $image;
        }, $images);
    }
}
