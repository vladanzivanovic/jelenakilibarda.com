<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Description;
use App\Formatter\Admin\DescriptionEditResponseFormatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class DescriptionEditPageController extends AbstractController
{
    private DescriptionEditResponseFormatter $responseFormatter;

    public function __construct(
        DescriptionEditResponseFormatter $responseFormatter
    ) {
        $this->responseFormatter = $responseFormatter;
    }

    /**
     * @Route("/add-description", name="admin.add_description_page", methods={"GET"})
     * @Template("Admin/Pages/descriptionEdit.html.twig")
     *
     * @return array
     */
    public function insert(): array
    {
        return [];
    }

    /**
     * @Route("/edit-description/{id}", name="admin.edit_description_page", methods={"GET"})
     * @Template("Admin/Pages/descriptionEdit.html.twig")
     *
     * @return array
     */
    public function update(Description $description): array
    {
        return $this->responseFormatter->formatResponse($description);
    }
}
