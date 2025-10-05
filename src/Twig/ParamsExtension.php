<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ParamsExtension extends AbstractExtension
{
    private ContainerInterface $container;

    private TranslatorInterface $translator;

    public function __construct(
        ContainerInterface $container,
        TranslatorInterface $translator
    ) {
        $this->container = $container;
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('app_params', [$this, 'getParams']),
            new TwigFunction('param_exist', [$this, 'isSetAndExist']),
            new TwigFunction('value_from_param', [$this, 'getValueFromParam']),
            new TwigFunction('locale_codes', [$this, 'getCodeFromLocales']),
            new TwigFunction('text_regulations_options', [$this, 'getTextRegulationsForOptions']),
        ];
    }

    /**
     * @param $parameter
     *
     * @return mixed
     */
    public function getParams($parameter)
    {
        return $this->container->getParameter($parameter);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function isSetAndExist($value)
    {
        return !empty($value);
    }

    /**
     * @param             $value
     * @param string      $param
     * @param string|null $arrayKey
     *
     * @return mixed
     */
    public function getValueFromParam($value, string $param, string $arrayKey = null)
    {
        $params = $this->getParams($param);

        if (is_string($arrayKey)) {
            $params = $params[$arrayKey];
        }

        return $params[$value];
    }

    /**
     * @return array
     */
    public function getCodeFromLocales(): array
    {
        return array_map(function ($locale) {
            return $locale['code'];
        }, $this->getParams('languages'));
    }

    public function getTextRegulationsForOptions(): array
    {
        return array_map(function ($text) {
            return [
                'title' => $this->translator->trans($text['title']),
                'value' => $text['type'],
            ];
        }, $this->getParams('text_regulations'));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'params_extension';
    }
}
