<?php
declare(strict_types = 1);

namespace vvt;

use vvt\Statement;

class MyDb
{
    private \PDO $connection;

    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['db_name']};charset={$config['charset']}";
        $this->connection = new \PDO($dsn,$config['db_user'], $config['password'], $config['options']);
        
    }
    public function query(string $sql, array $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return new Statement($stmt);
    }
    public function execute(string $sql, array $params)
    {
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params);
    }
}