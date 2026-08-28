<?php

namespace vvt;

final class Registry
{
    use TSingleton;

    private static array $properties = [];

    public function setProperty(string $name, array|string $value)
    {
        self::$properties[$name] = $value;
    }
    public function getProperty($name, $default = null)
    {
        return self::$properties[$name] ?? $default;
    }
    public function getProperties()
    {
        return self::$properties;
    }
}