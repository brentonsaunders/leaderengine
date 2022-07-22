<?php
namespace Views;

use Models\Department;

class ScenariosView extends View {
    private $scenarios = [];

    public function __construct($departmentName, $scenarios) {
        parent::__construct();

        $this->setActiveNavItem('scenarios');
        $this->setTitle($departmentName);

        $this->scenarios = $scenarios;
    }

    protected function main() {
        echo "<div id=\"scenarios\">\n";
        echo "<h1>Scenarios</h1>\n";

        foreach($this->scenarios as $scenario) {
            echo "<a href=\"?controller=scenarios&scenarioId={$scenario->getId()}\">{$scenario->getTitle()}</a>\n";
        }

        echo "</div>\n";
    }
}