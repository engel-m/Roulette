<?php

$pageTitle = "2 Player Roulette Game";
require __DIR__ . '/init.php';
require __DIR__ . '/RouletteControl.php';
?>

<head>
<link href='https://fonts.googleapis.com/css?family=Fjalla+One|Open+Sans' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet'>
<link rel='stylesheet' href='css/phproulettestyle.css' type='text/css'>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<link rel='stylesheet' href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js'></script>
</head>

<body>
<div class='maincontentholder'>
    <div class="intro">
        <h1 class='roulettepagetitle'><?= htmlentities($pageTitle) ?></h1>
        <p class='introtext'>Each player starts with 1000 chips. <?= $method; ?>
            Fill in the betting form below to bet any number of chips, however you want.</p>
    </div>

    <div id='maingrid'>
    <!-- Round Results Player 1 -->
        <?php $printer->printRoundResults(1, 'left', $method) ?>

    <!-- Roulette Wheel + Ball -->
        <div id='roulettecard'>
            <?php
             if (empty($game->getSession()->get('Players')) && (!$printer->getError()) OR $game->isExpired()) {
                $printer->printNameInputBox();
             }
             if (isset($e)) {
                $printer->printErrorBox();
             }
             ?>
            <br>
            <div id='roulettewheelholder'>
                <img src='img/roulette/wheel.png' id='roulettewheel' class='wheel<?= htmlentities($wheel->getSpin('number')) ?>' alt='Roulette Wheel' />
                <div id='ballholder' class='ball<?= htmlentities($wheel->getSpin('number')) ?>'>
                <img src='img/roulette/ball.png' id='rouletteball' alt='Roulette Ball' />
                </div>
            </div>
        </div>

    <!-- Round Results Player 2 -->
        <?php $printer->printRoundResults(2, 'right', $method) ?>
        <br>
        <br>

    <!-- Betting form for player 1 -->
        <div class='formcontent p1bets'>
            <form name='betform' action='roulettepost' method='post'>
                <?php $printer->printForm(1, $method) ?>
        </div>

    <!-- Buttons and spin results below the wheel itself -->
        <div class='wheelgame'>
            <div>
                <br>
                <input type='submit' value='Place bets and spin!'>
                <br><br><p class='fadein'>
                <?php
                    if (!empty($wheel->getSpinResults())) {
                        print_r('The ball landed on: <br><br> <span class="' . htmlentities($wheel->getSpin('color')) . '">' .
                            htmlentities($wheel->getSpin('number')) . ' ' . htmlentities($wheel->getSpin('color')) . '</span>');
                    } ?>
                </p>
            </div>

    <!-- Reset button; uses GET Method to redirect and reset all variables -->
            <div>
                <a id='resetbutton' href='roulette?newgame=1'>
                    Reset Scores and Start New Game</a><br><br>
            </div>
        </div>

    <!-- Betting form for player 2 -->
        <div class='formcontent p2bets'>
            <?php $printer->printForm(2, $method) ?>
            </form>
        </div>
    </div>
</div>

</body>

</html>
