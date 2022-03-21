<?php
namespace Database;

class Subscribers extends DB
{
    private $table_name = 'subscribers';
    public function getAll() {
        return $this->selectAll($this->table_name);
    }

    public function addEntity($entity) {
        return $this->insertEntity($entity, $this->table_name);
    }
}