<?php

declare(strict_types=1);

namespace App\Formatter\Admin;

use App\Entity\EntityInterface;
use App\Helper\ConstantsHelper;
use App\Model\DataTableModel;
use Symfony\Component\Routing\RouterInterface;

final class VideoDataTableResponseFormatter
{
    use DataTableResponseTrait;

    private RouterInterface $router;

    public function __construct(
        RouterInterface $router
    ) {
        $this->router = $router;
    }

    /**
     * @param DataTableModel $tableModel
     * @param array          $data
     * @param int            $total
     *
     * @return array
     */
    public function formatResponse(DataTableModel $tableModel, array $data, int $total): array
    {
//        $router = $this->router;
//
        $data = array_map(function ($item) {
            $statusText = ConstantsHelper::getConstantName(
                (string)$item['status'],
                'STATUS',
                EntityInterface::class
            );

            $item['status_text'] = $statusText;

            $item['image'] = $item['thumbnails']['default']['url'];

            return $item;
        }, $data);

        return $this->response($tableModel, $data, $total);

    }
}
