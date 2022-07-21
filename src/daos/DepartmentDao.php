<?php
namespace Daos;

use Models\Department;
use Database;

class DepartmentDao {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAll() {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM departments'
        );

        $departments = [];

        foreach($rows as $row) {
            $departments[] = new Department($row['id'], $row['name']);
        }

        return $departments;
    }

    public function getById($id) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM departments ' . 
            'WHERE id = :id',
            [':id' => $id]
        );

        if(count($rows) === 0) {
            return null;
        }

        $row = $rows[0];

        return new Department($row['id'], $row['name']);
    }
}