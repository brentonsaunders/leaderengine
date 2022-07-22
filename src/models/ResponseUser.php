<?php
namespace Models;

use Models\Response;
use Models\User;

class ResponseUser {
    private Response $response;
    private User $user;

    public function __construct(Response $response, User $user) {
        $this->response = $response;
        $this->user = $user;
    }

    public function getResponse() {
        return $this->response;
    }

    public function getUser() {
        return $this->user;
    }
}