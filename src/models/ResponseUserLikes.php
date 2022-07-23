<?php
namespace Models;

use Models\Response;
use Models\User;

class ResponseUserLikes {
    private Response $response;
    private User $user;
    private $likes = 0;
    private $likedByCurrentUser = false;

    public function __construct(Response $response, User $user, $likes,
        $likedByCurrentUser = false) {
        $this->response = $response;
        $this->user = $user;
        $this->likes = $likes;
        $this->likedByCurrentUser = $likedByCurrentUser;
    }

    public function getResponse() {
        return $this->response;
    }

    public function getUser() {
        return $this->user;
    }

    public function getLikes() {
        return $this->likes;
    }

    public function getLikedByCurrentUser() {
        return $this->likedByCurrentUser;
    }
}