<?php

declare(strict_types=1);

namespace App\Controller\Site;

use App\Collector\Site\ContactPageCollector;
use App\Formatter\Site\ContactPageResponseFormatter;
use App\Repository\SettingsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ContactPageController extends AbstractController
{
    private SettingsRepository $settingsRepository;

    private ContactPageCollector $contactPageCollector;

    private ContactPageResponseFormatter $contactPageResponseFormatter;

    /**
     * @param SettingsRepository $settingsRepository
     */
    public function __construct(
        SettingsRepository $settingsRepository,
        ContactPageCollector $contactPageCollector,
        ContactPageResponseFormatter $contactPageResponseFormatter
    ) {
        $this->settingsRepository = $settingsRepository;
        $this->contactPageCollector = $contactPageCollector;
        $this->contactPageResponseFormatter = $contactPageResponseFormatter;
    }

    /**
     * @Route({
     *          "rs": "/kontakt",
     *          "en": "/contact"
     *     },
     *     name="site.contact_page",
     *     methods={"GET"}
     * )
     * @Template("Site/Pages/contact.html.twig")
     *
     * @param Request $request
     *
     * @return array
     * @throws \ReflectionException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function renderPage(Request $request): array
    {
        $data = $this->contactPageCollector->collect($request->getLocale());

        return $this->contactPageResponseFormatter->formatResponse($data);
    }
}
