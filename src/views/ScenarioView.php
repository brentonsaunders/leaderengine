<?php
namespace Views;

use Models\Scenario;
use Models\ResponseUserLikes;

class ScenarioView extends View {
    private Scenario $scenario;
    private $responseUserLikes = [];

    public function __construct(Scenario $scenario, $responseUserLikes) {
        parent::__construct();

        $this->setActiveNavItem('scenarios');
        $this->setTitle('Scenario');

        $this->scenario = $scenario;
        $this->responseUserLikes = $responseUserLikes;
    }

    protected function main() {
        echo "<div id=\"scenario\">\n";
        echo "<h1>{$this->scenario->getTitle()}</h1>\n";
        echo "<p>Scenario: {$this->scenario->getDescription()}</p>\n";
        echo "<p>Objective: {$this->scenario->getObjective()}</p>\n";
        echo "<div id=\"responses\">\n";
        echo "<h2>Responses</h2>\n";

        if(count($this->responseUserLikes) === 0) {
            echo "<p>No responses yet. Be the first to add one.</p>\n";
        } else {
            foreach($this->responseUserLikes as $responseUserLikes) {
                $text = $responseUserLikes->getResponse()->getText();
                $name = $responseUserLikes->getUser()->getName();
                $email = $responseUserLikes->getUser()->getEmail();

                echo $responseUserLikes->getLikes();
                echo ($responseUserLikes->getLikedByCurrentUser()) ? ',true' : ',false';

                echo "<a class=\"response box\" href=\"\">$text<div class=\"user\">$name ($email)</div></a>\n";
            }
        }

        echo "</div>\n";
        echo "</div>\n";
    }
}