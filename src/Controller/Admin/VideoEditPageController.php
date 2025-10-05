<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Slider;
use App\Entity\Video;
use App\Formatter\Admin\SliderEditResponseFormatter;
use App\Formatter\Admin\VideoEditResponseFormatter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;

final class VideoEditPageController extends AbstractController
{
    private VideoEditResponseFormatter $responseFormatter;

    public function __construct(
        VideoEditResponseFormatter $responseFormatter
    ) {
        $this->responseFormatter = $responseFormatter;
    }

    /**
     * @Route("/add-video", name="admin.add_video_page", methods={"GET"})
     * @Template("Admin/Pages/videoEdit.html.twig")
     *
     * @return array
     */
    public function insert(): array
    {
        return [];
    }

    /**
     * @Route("/edit-video/{id}", name="admin.edit_video_page", methods={"GET"})
     * @Template("Admin/Pages/videoEdit.html.twig")
     *
     * @return array
     */
    public function update(Video $video): array
    {
        return $this->responseFormatter->formatResponse($video);
    }
}
