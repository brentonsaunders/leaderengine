<?php
namespace Daos;

use Database;

class ResponseLikesDao {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getByResponseId($responseId) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM response_likes ' . 
            'WHERE response_id = :response_id',
            [':response_id' => $responseId]
        );

        return count($rows);
    }

    public function getByResponseIdAndUserId($responseId, $userId) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM response_likes ' . 
            'WHERE response_id = :response_id AND ' . 
            'user_id = :user_id',
            [':response_id' => $responseId, ':user_id' => $userId]
        );

        return count($rows);
    }

    public function insert($responseId, $userId) {
        $this->db->query(
            'INSERT INTO response_likes ' . 
            '(response_id, user_id) ' . 
            'VALUES ' .
            '(:response_id, :user_id)',
            [
                'response_id' => $responseId,
                'user_id' => $userId
            ]
        );
    }

    public function delete($responseId, $userId) {
        $this->db->query(
            'DELETE FROM response_likes ' . 
            'WHERE response_id = :response_id AND ' . 
            'user_id = :user_id',
            [
                ':response_id' => $responseId,
                ':user_id' => $userId
            ]
        );
    }
}