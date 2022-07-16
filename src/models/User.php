<?php
namespace Models;

class User {
    private $id = null;
    private $email = null;
    private $password = null;
    private $hash = null;
    private $name = null;
    private $verified = null;
    private $verificationCode = null;
    private $verificationExpiry = null;

    public function __construct($id, $email, $password, $hash, $name, $verified,
        $verificationCode, $verificationExpiry) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->hash = $hash;
        $this->name = $name;
        $this->verified = $verified;
        $this->verificationCode = $verificationCode;
        $this->verificationExpiry = $verificationExpiry;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getHash() {
        if($this->hash === null) {
            $this->hash = password_hash($this->password, PASSWORD_DEFAULT);
        }

        return $this->hash;
    }

    public function getName() {
        return $this->name;
    }

    public function getVerified() {
        return $this->verified;
    }

    public function getVerificationCode() {
        return $this->verificationCode;
    }

    public function getVerificationExpiry() {
        return $this->verificationExpiry;
    }

    public function verificationExpired() {
        $expiry = strtotime($this->verificationExpiry);
        $now = strtotime('now');

        $seconds = $expiry - $now;

        return $seconds <= 0;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->hash = null;
        
        $this->password = $password;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setVerified($verified) {
        $this->verified = $verified;
    }

    public function setVerificationCode($verificationCode) {
        $this->verificationCode = $verificationCode;
    }

    public function setVerificationExpiry($verificationExpiry) {
        $this->verificationExpiry = $verificationExpiry;
    }
}