<?php
namespace Daos;

use Models\User;
use Database;

class UserDao {
    private $db = null;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getById($id) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM users ' . 
            'WHERE id = :id',
            [
                ':id' => $id
            ]
        );

        if(count($rows) === 0) {
            return null;
        }

        $row = $rows[0];

        return new User(
            $row['id'],
            $row['email'],
            null,
            $row['password'],
            $row['name'],
            $row['verified'],
            $row['verification_code'],
            $row['verification_expiry']
        );
    }

    public function getByEmail($email) {
        $rows = $this->db->query(
            'SELECT * ' . 
            'FROM users ' . 
            'WHERE email = :email',
            [
                ':email' => $email
            ]
        );

        if(count($rows) === 0) {
            return null;
        }

        $row = $rows[0];

        return new User(
            $row['id'],
            $row['email'],
            null,
            $row['password'],
            $row['name'],
            $row['verified'],
            $row['verification_code'],
            $row['verification_expiry']
        );
    }

    public function insert(User $user) {
        $this->db->query(
            'INSERT INTO users (email, password, name, verified, verification_code, verification_expiry) ' . 
            'VALUES (:email, :password, :name, :verified, :verification_code, :verification_expiry)',
            [
                ':email' => $user->getEmail(),
                ':password' => $user->getHash(),
                ':name' => $user->getName(),
                ':verified' => $user->getVerified(),
                ':verification_code' => $user->getVerificationCode(),
                ':verification_expiry' => $user->getVerificationExpiry()
            ]
        );
    }

    public function update(User $user) {
        $this->db->query(
            'UPDATE users ' . 
            'SET email = :email, ' . 
            'password = :password, ' . 
            'name = :name, ' . 
            'verified = :verified, ' . 
            'verification_code = :verification_code, ' .
            'verification_expiry = :verification_expiry ' .
            'WHERE id = :id',
            [
                ':email' => $user->getEmail(),
                ':password' => $user->getHash(),
                ':name' => $user->getName(),
                ':verified' => $user->getVerified(),
                ':verification_code' => $user->getVerificationCode(),
                ':verification_expiry' => $user->getVerificationExpiry(),
                ':id' => $user->getId()
            ]
        );
    }

    public function delete(User $user) {
        $this->db->query(
            'DELETE FROM users ' . 
            'WHERE id = :id',
            [
                ':id' => $user->getId()
            ]
            );
    }
}