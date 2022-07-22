<?php
namespace Daos;

use Models\Scenario;
use Database;

class ScenarioDao {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAll() {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM scenarios'
        );

        if(count($rows) === 0) {
            return [];
        }

        $scenarios = [];

        foreach($rows as $row) {
            $scenarios[] = new Scenario(
                $row['id'],
                $row['department_id'],
                $row['user_id'],
                $row['editor_id'],
                $row['title'],
                $row['description'],
                $row['objective'],
                $row['time'],
                $row['approved']
            );
        }

        return $scenarios;
    }

    public function getByUserId($userId) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM scenarios ' . 
            'WHERE user_id = :user_id',
            [':user_id' => $userId]
        );

        $scenarios = [];

        foreach($rows as $row) {
            $scenarios[] = new Scenario(
                $row['id'],
                $row['department_id'],
                $row['user_id'],
                $row['editor_id'],
                $row['title'],
                $row['description'],
                $row['objective'],
                $row['time'],
                $row['approved']
            );
        }

        return $scenarios;
    }

    public function getByDepartmentId($departmentId) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM scenarios ' . 
            'WHERE department_id = :department_id',
            [':department_id' => $departmentId]
        );

        $scenarios = [];

        foreach($rows as $row) {
            $scenarios[] = new Scenario(
                $row['id'],
                $row['department_id'],
                $row['user_id'],
                $row['editor_id'],
                $row['title'],
                $row['description'],
                $row['objective'],
                $row['time'],
                $row['approved']
            );
        }

        return $scenarios;
    }
    
    public function getById($id) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM scenarios ' . 
            'WHERE id = :id',
            [':id' => $id]
        );

        if(count($rows) === 0) {
            return null;
        }

        $row = $rows[0];

        return new Scenario(
            $row['id'],
            $row['department_id'],
            $row['user_id'],
            $row['editor_id'],
            $row['title'],
            $row['description'],
            $row['objective'],
            $row['time'],
            $row['approved']
        );
    }

    public function insert(Scenario $scenario) {
        $this->db->query(
            'INSERT INTO scenarios ' . 
            '(department_id, user_id, editor_id, title, description, objective, time, approved) ' . 
            'VALUES ' . 
            '(:department_id, :user_id, :editor_id, :title, :description, :objective, NOW(), :approved)',
            [
                ':department_id' => $scenario->getDepartmentId(),
                ':user_id' => $scenario->getUserId(),
                ':editor_id' => $scenario->getEditorId(),
                ':title' => $scenario->getTitle(),
                ':description' => $scenario->getDescription(),
                ':objective' => $scenario->getObjective(),
                ':approved' => false
            ]
        );
    }

    public function update(Scenario $scenario) {
        $this->db->query(
            'UPDATE scenarios ' . 
            'SET ' . 
            'department_id = :department_id, ' . 
            'user_id = :user_id, ' . 
            'editor_id = :editor_id, ' . 
            'title = :title, ' . 
            'description = :description, ' . 
            'objective = :objective, ' . 
            'time = :time, ' . 
            'approved = :approved ' . 
            'WHERE id = :id',
            [
                ':department_id' => $scenario->getDepartmentId(),
                ':user_id' => $scenario->getUserId(),
                ':editor_id' => $scenario->getEditorId(),
                ':title' => $scenario->getTitle(),
                ':description' => $scenario->getDescription(),
                ':objective' => $scenario->getObjective(),
                ':time' => $scenario->getTime(),
                ':approved' => $scenario->getApproved(),
                ':id' => $scenario->getId()
            ]
        );
    }

    function delete(Scenario $scenario) {
        $this->db->query(
            'DELETE FROM scenarios ' . 
            'WHERE id = :id',
            [':id' => $scenario->getId()]
        );
    }
}