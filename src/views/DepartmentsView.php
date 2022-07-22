<?php
namespace Views;

use Models\Department;

class DepartmentsView extends View {
    private $departments = [];

    public function __construct($departments) {
        parent::__construct();

        $this->setActiveNavItem('scenarios');
        $this->setTitle('Departments');

        $this->departments = $departments;
    }

    protected function main() {
        echo "<div id=\"departments\">\n";

        foreach($this->departments as $department) {
            echo "<a href=\"?controller=scenarios&departmentId={$department->getId()}\">{$department->getName()}</a>\n";
        }

        echo "</div>\n";
    }
}