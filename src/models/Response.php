<?php
namespace Models;

class Response {
    private $id = null;
    private $scenarioId = null;
    private $responseId = null;
    private $userId = null;
    private $editorId = null;
    private $fromYou = null;
    private $text = null;
    private $time = null;
    private $approved = null;

    public function __construct(
        $id,
        $scenarioId,
        $responseId,
        $userId,
        $editorId,
        $fromYou,
        $text,
        $time,
        $approved
    ) {
        $this->id = $id;
        $this->scenarioId = $scenarioId;
        $this->responseId = $responseId;
        $this->userId = $userId;
        $this->editorId = $editorId;
        $this->fromYou = $fromYou;
        $this->text = $text;
        $this->time = $time;
        $this->approved = $approved;
    }

    public function getId() {
        return $this->id;
    }

    public function getScenarioId() {
        return $this->scenarioId;
    }

    public function getResponseId() {
        return $this->responseId;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getEditorId() {
        return $this->editorId;
    }

    public function getFromYou() {
        return $this->fromYou;
    }

    public function getText() {
        return $this->text;
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

    public function setScenarioId($scenarioId) {
        $this->scenarioId = $scenarioId;
    }

    public function setResponseId($responseId) {
        $this->responseId = $responseId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setEditorId($editorId) {
        $this->editorId = $editorId;
    }

    public function setFromYou($fromYou) {
        $this->fromYou = $fromYou;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function setApproved($approved) {
        $this->approved = $approved;
    }
}