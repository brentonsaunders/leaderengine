<?php
namespace Models;

class Scenario {
    private $id = null;
    private $departmentId = null;
    private $userId = null;
    private $editorId = null;
    private $title = null;
    private $description = null;
    private $objective = null;
    private $time = null;
    private $approved = null;

    public function __construct(
        $id,
        $departmentId,
        $userId,
        $editorId,
        $title,
        $description,
        $objective,
        $time,
        $approved
    ) {
        $this->id = $id;
        $this->departmentId = $departmentId;
        $this->userId = $userId;
        $this->editorId = $editorId;
        $this->title = $title;
        $this->description = $description;
        $this->objective = $objective;
        $this->time = $time;
        $this->approved = $approved;
    }

    public function getId() {
        return $this->id;
    }

    public function getDepartmentId() {
        return $this->departmentId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getEditorId() {
        return $this->editorId;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getObjective() {
        return $this->objective;
    }

    public function getTime() {
        return $this->time;
    }

    public function getApproved() {
        return $this->approved;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDepartmentId($departmentId) {
        $this->departmentId = $departmentId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setEditorId($editorId) {
        $this->editorId = $editorId;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setObjective($objective) {
        $this->objective = $objective;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function setApproved($approved) {
        $this->approved = $approved;
    }
}