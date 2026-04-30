<?php
namespace vvt;

trait TSingleton
{
    protected static ?self $instance = null;
    private function __construct(){}

    public static function getInstance():static
    {
        return static::$instance ?? static::$instance = new static();
    }
}

// вариант, если будет нужно наследование в классе, использующем этот трейт
// trait TSingleton
// {
        ////создаем массив, где будем хранить название класса -> экземпляр класса 
        ////это будет одно свойство, которое будет храниться в родительском классе 
//     private static array $instances = [];
//     private function __construct(){}

//     public static function getInstance():static
//     {
//         $class = static::class;
//         return self::$instances[$class] ?? self::$instances[$class] = new static();
//     }
// }