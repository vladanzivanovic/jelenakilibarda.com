<?php

declare(strict_types=1);

namespace App\Formatter\Admin;

use App\Entity\Video;

final class VideoEditResponseFormatter
{
    /**
     * @return array<string, mixed>
     */
    public function formatResponse(Video $video): array
    {
        $data = [
            'video' => $video,
        ];

        return $data;
    }
}
