<?php
namespace Views;

use Models\Scenario;
use Models\ResponseUser;

class ScenarioView extends View {
    private Scenario $scenario;
    private $responseUsers = [];

    public function __construct(Scenario $scenario, $responseUsers) {
        parent::__construct();

        $this->setActiveNavItem('scenarios');
        $this->setTitle('Scenario');

        $this->scenario = $scenario;
        $this->responseUsers = $responseUsers;
    }

    protected function main() {
        echo "<div id=\"scenario\">\n";
        echo "<h1>{$this->scenario->getTitle()}</h1>\n";
        echo "<p>Scenario: {$this->scenario->getDescription()}</p>\n";
        echo "<p>Objective: {$this->scenario->getObjective()}</p>\n";
        echo "<div id=\"responses\">\n";
        echo "<h2>Responses</h2>\n";

        if(count($this->responseUsers) === 0) {
            echo "<p>No responses yet. Be the first to add one.</p>\n";
        } else {
            foreach($this->responseUsers as $responseUser) {
                $text = $responseUser->getResponse()->getText();
                $name = $responseUser->getUser()->getName();
                $email = $responseUser->getUser()->getEmail();

                echo "<a class=\"response box\" href=\"\">$text<div class=\"user\">$name ($email)</div></a>\n";
            }
        }

        echo "</div>\n";
        echo "</div>\n";
    }
}