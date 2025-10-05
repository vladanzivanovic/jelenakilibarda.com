<?php

namespace App\Repository;

use App\Model\DataTableModel;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

interface DataTableRepositoryInterface
{
    /**
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countData();

    /**
     * @param DataTableModel $tableModel
     *
     * @return array
     */
    public function getAdminList(DataTableModel $tableModel): array;
}