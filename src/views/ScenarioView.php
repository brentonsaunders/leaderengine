<?php
namespace Views;

use Models\Scenario;

class ScenarioView extends View {
    private Scenario $scenario;
    private $responses = [];

    public function __construct(Scenario $scenario, $responses) {
        parent::__construct();

        $this->setActiveNavItem('scenarios');
        $this->setTitle('Scenario');

        $this->scenario = $scenario;
        $this->responses = $responses;
    }

    protected function main() {

        echo "<div id=\"scenario\">\n";
        echo "<h1>{$this->scenario->getTitle()}</h1>\n";
        echo "<p>Scenario: {$this->scenario->getDescription()}</p>\n";
        echo "<p>Objective: {$this->scenario->getObjective()}</p>\n";
        echo "<div id=\"responses\">\n";
        echo "<h2>Responses</h2>\n";

        if(count($this->responses) === 0) {
            echo "<p>No responses yet. Be the first to add one.</p>\n";
        } else {
            foreach($this->responses as $response) {
                echo "<a class=\"response box\">{$response->getText()}<div class=\"user\">saubrent@amazon.com</div></a>\n";
            }
        }

        echo "</div>\n";
        echo "</div>\n";
    }
}