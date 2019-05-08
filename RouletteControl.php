<?php
use Roulette\Game;
use Roulette\HTMLPrinter;
use Roulette\Wheel;

require __DIR__ . '/init.php';

$method = $_SERVER['REQUEST_METHOD'];
//Create Roulette Wheel Object
$wheel = new Wheel();

// Start new game (also constructs new Session, Wheel object
// Accepts optional Player @array argument in the form id => 'name'
// If a game is already running, Game class handles the rest through the constructor with sessions.
if (isset($_POST['names'])) {
    $game = new Game($wheel, $_POST['names']);
    $game->savePlayers();
} else {
    $game = new Game($wheel);
}

// Reset game if reset button was clicked.
if ( isset($newgame) || $game->isExpired()) {
    $game->getSession()->end();
    unset($game);
    $game = new Game($wheel);
}

// Make HTML printer (for forms etc) available
$printer = new HTMLPrinter($game->getPlayersArray(), Wheel::getWheelArray());

//Try placing player bets
$e = null;  // Error message
if ($method == 'POST' && !isset($_POST['names'])) {
    try {
        $game->placeBets($_POST);
    } catch (OutOfRangeException $e) {
        $printer->setError($e->getMessage());
    }
}

// Spin wheel always, unless there were errors in the bet submission
if (!isset($e)) {
    $wheel->spin();
}

// Calculate scores/payouts for each player
if ($method == 'POST' && !isset($e) && !isset($_POST['names'])) {
    $game->calcResults();    
}







