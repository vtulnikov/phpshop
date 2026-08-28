<?php

namespace vvt;

final class Registry
{
    use TSingleton;

    private static array $properties = [];

    public function setProperty($name, $value)
    {
        self::$properties[$name] = $value;
    }
    public function getProperty(string $name, $default = null)
    {
        return self::$properties[$name] ?? $default;
    }
    public function getProperties()
    {
        return self::$properties;
    }
}