<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Banner;
use App\Entity\Catalogue;
use App\Formatter\Admin\BannerEditResponseFormatter;
use App\Formatter\Admin\CatalogResponseFormatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;

final class CatalogEditPageController extends AbstractController
{
    private CatalogResponseFormatter $responseFormatter;

    public function __construct(
        CatalogResponseFormatter $responseFormatter
    ) {
        $this->responseFormatter = $responseFormatter;
    }

    /**
     * @Route("/catalog", name="admin.save_catalog_page", methods={"GET"})
     * @Template("Admin/Pages/catalogEdit.html.twig")
     *
     * @return array
     */
    public function set(): array
    {
        return $this->responseFormatter->formatResponse();
    }
}
