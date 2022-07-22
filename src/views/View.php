<?php
namespace Views;

class View {
    private $title = 'Home';
    private $stylesheets = [
        'css/index.css'
    ];
    private $scripts = [
        'js/jquery-3.6.0.min.js',
        'js/index.js'
    ];
    private $activeNavItem = 'home';
    private $navItems = [
        ['title' => 'Home', 'name' => 'home', 'url' => '?'],
        ['title' => 'Scenarios', 'name' => 'scenarios', 'url' => '?controller=scenarios'],
        ['title' => 'About', 'name' => 'about', 'url' => '?action=about'],
        ['title' => 'Privacy', 'name' => 'privacy', 'url' => '?action=privacy'],
    ];

    public function __construct() {

    }

    public function addStylesheet($stylesheet) {
        $this->stylesheets[] = $stylesheet;
    }

    public function addScript($script) {
        $this->scripts[] = $script;
    }

    public function setActiveNavItem($item) {
        $this->activeNavItem = $item;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    protected function head() {
        echo "<title>Leader Engine</title>\n";
        echo "<meta charset=\"UTF-8\">\n";
        echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no\">\n";
    
        foreach($this->stylesheets as $stylesheet) {
            echo "<link rel=\"stylesheet\" href=\"$stylesheet\">\n";
        }

        foreach($this->scripts as $script) {
            echo "<script src=\"$script\"></script>\n";
        }
    }

    protected function header() {
        
        echo <<<EOD
<div id="menu-button"></div>
<div id="back-button"></div>
<div id="title">{$this->title}</div>
<div id="settings-button"></div>
<nav>
    <div id="close-button"></div>
    <ul>
EOD;

        foreach($this->navItems as $item) {
            $class = '';

            if($item['name'] === $this->activeNavItem) {
                $class = 'active';
            }

            echo "<li><a class=\"$class\" name=\"{$item['name']}\" href=\"{$item['url']}\">{$item['title']}</a></li>\n";
        }

        echo <<<EOD
    </ul>
    <div id="copyright">&copy; 2022 Brenton Saunders</div>
</nav>
EOD;
    }

    protected function main() {
        echo <<<EOD

EOD;
    }

    protected function footer() {

    }

    protected function body() {
        echo "<div id=\"app\">\n";

        echo "<header>\n";

        $this->header();

        echo "</header>\n";

        echo "<main>\n";

        $this->main();

        echo "</main>\n";

        echo "<footer>\n";

        $this->footer();

        echo "</footer>\n";

        echo "</div>\n";
    }

    protected function html() {
        echo "<head>\n";

        $this->head();

        echo "</head>\n";

        echo "<body>\n";

        $this->body();

        echo "</body>\n";
    }

    public function render() {
        echo "<!DOCTYPE html>\n";
        echo "<html>\n";

        $this->html();

        echo "</html>\n";
    }
}