<?php
namespace Views;

class TemplateView extends View {
    private $template = null;

    public function __construct($template) {
        parent::__construct();
        
        $this->template = $template;
    }

    protected function main() {
        require_once \Config::getTemplateDir() . DIRECTORY_SEPARATOR . $this->template;
    }
}