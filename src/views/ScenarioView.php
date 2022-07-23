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

        $this->addScript('js/scenario.js');

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
                $responseId = $responseUserLikes->getResponse()->getId();


                $liked = ($responseUserLikes->getLikedByCurrentUser()) ? 'liked' : '';

                $likes = $responseUserLikes->getLikes();

                echo "<div class=\"response\"><div data-response-id=\"$responseId\" class=\"likes $liked\"><a class=\"num-likes\">$likes</a></div><a class=\"box\" href=\"\">$text</a><div class=\"user\">$name ($email)</div></div>\n";
            }
        }

        echo "</div>\n";
        echo "<div id=\"add\"></div>\n";
        echo "</div>\n";

        echo "<div id=\"add-response\">\n";
        echo "<div id=\"close-button\"></div>\n";
        echo "<form>\n";
        echo "<h1>Add Response</h1>\n";
        echo "<div id=\"the-scenario\"></div>\n";
        echo "<p class=\"rules\">Rules: Add a response to the above scenario. Your response should be <strong>spoken dialogue</strong> written from the perspective of the <strong>associate</strong>, and should be written in the <strong>first-person</strong> only (i.e., I, me, we). Your response should be at least <strong>100 characters</strong> long.</p>\n";
        echo "<div id=\"your-response\">\n";
        echo "<textarea placeholder=\"Your Response\"></textarea>\n";
        echo "<div id=\"num-characters\">0</div>\n";
        echo "<input type=\"submit\" value=\"Submit\" />\n";
        echo "</div>\n";
        echo "</form>\n";
        echo "</div>\n";
    }
}