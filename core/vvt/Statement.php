<?php
declare(strict_types = 1);

namespace vvt;

final class Statement
{
    public function __construct(
        private \PDOStatement $stmt)
    {}
    public function find()
    {
        return $this->stmt->fetch();
    }
    public function findAll()
    {
        return $this->stmt->fetchAll();
    }
}