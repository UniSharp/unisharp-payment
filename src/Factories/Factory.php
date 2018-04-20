<?php
namespace UniSharp\Payment\Factories;

abstract class Factory
{
    protected static $registered = [
    ];

    public static function create(string $name, array $config)
    {
        if (!array_key_exists($name, static::$registered)) {
            throw new NotRegisteredInFactoryException();
        }

        $class = static::$registered[$name];
        return new $class($config);
    }

    public static function register(string $name, string $class)
    {
        static::$registered[$name] = $class;
    }
}
