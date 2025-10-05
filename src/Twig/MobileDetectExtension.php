<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MobileDetectExtension extends AbstractExtension
{
    protected \Mobile_Detect $detector;

    public function __construct()
    {
        $this->detector = new \Mobile_Detect();
    }

    public function getFunctions(): array
    {
        $functions = array(
            new TwigFunction('get_available_devices', array($this, 'getAvailableDevices')),
            new TwigFunction('is_mobile', array($this, 'isMobile')),
            new TwigFunction('is_tablet', array($this, 'isTablet'))
        );

        foreach ($this->getAvailableDevices() as $device => $fixedName) {
            $methodName = 'is'.$device;
            $twigFunctionName = 'is_'.$fixedName;
            $functions[] = new TwigFunction($twigFunctionName, array($this, $methodName));
        }

        return $functions;
    }

    public function getAvailableDevices(): array
    {
        $availableDevices = array();
        $rules = array_change_key_case($this->detector->getRules());

        foreach ($rules as $device => $rule) {
            $availableDevices[$device] = static::fromCamelCase($device);
        }

        return $availableDevices;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->detector, $name), $arguments);
    }

    public function getName(): string
    {
        return 'mobile_detect.twig.extension';
    }

    protected static function toCamelCase($string)
    {
        return preg_replace('~\s+~', '', lcfirst(ucwords(strtr($string, '_', ' '))));
    }

    protected static function fromCamelCase($string, $separator = '_'): string
    {
        return strtolower(preg_replace('/(?!^)[[:upper:]]+/', $separator.'$0', $string));
    }
}
