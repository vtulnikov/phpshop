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
    public function getProperty(string $name, mixed $default = null):mixed
    {
        return self::$properties[$name] ?? $default;
    }
    public function getProperties()
    {
        return self::$properties;
    }
}