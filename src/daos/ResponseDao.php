<?php
namespace Daos;

use Models\Response;
use Database;

class ResponseDao {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getById($id) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM responses ' . 
            'WHERE id = :id',
            [':id' => $id]
        );

        if(count($rows) === 0) {
            return null;
        }

        $row = $rows[0];

        return new Response(
            $row['id'],
            $row['scenario_id'],
            $row['response_id'],
            $row['user_id'],
            $row['editor_id'],
            $row['from_you'],
            $row['text'],
            $row['time'],
            $row['approved']
        );
    }

    public function getByUserId($userId) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM responses ' . 
            'WHERE user_id = :user_id',
            [':user_id' => $userId]
        );

        if(count($rows) === 0) {
            return null;
        }

        $responses = [];

        foreach($rows as $row) {
            $responses[] = new Response(
                $row['id'],
                $row['scenario_id'],
                $row['response_id'],
                $row['user_id'],
                $row['editor_id'],
                $row['from_you'],
                $row['text'],
                $row['time'],
                $row['approved']
            );
        }

        return $responses;
    }

    public function getByScenarioId($scenarioId) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM responses ' . 
            'WHERE scenario_id = :scenario_id',
            [':scenario_id' => $scenarioId]
        );

        if(count($rows) === 0) {
            return null;
        }

        $responses = [];

        foreach($rows as $row) {
            $responses[] = new Response(
                $row['id'],
                $row['scenario_id'],
                $row['response_id'],
                $row['user_id'],
                $row['editor_id'],
                $row['from_you'],
                $row['text'],
                $row['time'],
                $row['approved']
            );
        }

        return $responses;
    }

    public function insert(Response $response) {
        $this->db->query(
            'INSERT INTO responses ' . 
            '(scenario_id, response_id, user_id, editor_id, from_you, text, time) ' . 
            'VALUES ' . 
            '(:scenario_id, :response_id, :user_id, :editor_id, :from_you, :text, NOW())',
            [
                ':scenario_id' => $response->getScenarioId(),
                ':response_id' => $response->getResponseId(),
                ':user_id' => $response->getUserId(),
                ':editor_id'=> $response->getEditorId(),
                ':from_you' => $response->getFromYou(),
                ':text' => $response->getText()
            ]
        );
    }

    public function update(Response $response) {
        $this->db->query(
            'UPDATE responses ' . 
            'SET scenario_id = :scenario_id, ' . 
            'response_id = :response_id, ' . 
            'user_id = :user_id, ' . 
            'editor_id = :editor_id, ' . 
            'from_you = :from_you, ' . 
            'text = :text, ' . 
            'approved = :approved ' .
            'WHERE id = :id',
            [
                ':scenario_id' => $response->getScenarioId(),
                ':response_id' => $response->getResponseId(),
                ':user_id' => $response->getUserId(),
                ':editor_id'=> $response->getEditorId(),
                ':from_you' => $response->getFromYou(),
                ':text' => $response->getText(),
                ':approved' => $response->getApproved(),
                ':id' => $response->getId()
            ]
        );
    }

    public function delete(Response $response) {
        $this->db->query(
            'DELETE FROM responses ' .
            'WHERE id = :id',
            [':id' => $response->getId()]
        );
    }
}