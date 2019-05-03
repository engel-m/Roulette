<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/24/18
 * Time: 22:23
 */

namespace Roulette;


class HTMLPrinter
{
    protected $playerArray;

    protected $wheelData;

    protected $error = '';

    public function __construct(array $playerArray, array $wheelData)
    {
        $this->playerArray = $playerArray;
        $this->wheelData = $wheelData;
    }

// Function to print results
    public function printRoundResults(int $player, string $position, $method)
    {
        $total = $this->playerArray[$player]->getLastTotal();

        echo '<div class="resultarea ' . $position . 'results ';
            if (htmlentities($method) == 'GET' || isset($_POST["names"])) {
                echo'transparent';
            } elseif (htmlentities($method) == 'POST' && (!$this->error) && !isset($_POST["names"])) {
                echo 'fadeinlate';
            }
        echo '"><h2>Result of Round for ' . $this->playerArray[$player]->getPlayerName() . ':</h2>';

        if ($total < 0) {
            echo '<h1 class="Red">';
        }
        elseif ($total > 0) {
            echo '<h1 class="Green">+';
        }
        else {
            echo '<h1>';
        }
        echo $total . '</h1></div>';
    }

// Function to print a betting form for each player

    public function printForm(int $player, $method)
    {
        echo '<div class="scorecontent"><h2 class="playertitle">'. $this->playerArray[$player]->getPlayerName() .
            '</h2><h1 class="chipcount"><span ';
        if ($method == 'POST' && (!$this->error) && !isset($_POST["names"])) {
            echo'class="fadeinlater"';
        }
        echo '>' . $this->playerArray[$player]->getChips() . '</span></h1></div>';

        echo '<p>Bets</p><div class="listblock">
         <div class="payout">Red/Black: 1 to 1 </div><div class="payout">Odd/Even: 1 to 1</div>    
         <div class="payout">Number Range: 1 to 1</div><div class="payout">Single Number: 35 to 1</div></div><br>';

        $options = array('Red', 'Black', 'Odd', 'Even', '1to18', '19to36');
        echo '<div id="bettinggrid' . $player . '">';
        foreach ($options as $key => $option) {
            echo '<div class="betfield">';
            echo '<label for="' . $player . '[' . $option . ']" class="' . $option . ' betoption">';
            switch ($option) {
                case ('1to18'):
                    echo '1-18';
                    break;
                case ('19to36'):
                    echo '19-36 ';
                    break;
                default:
                    echo $option;
            }
            echo '</label><input type="number" step="1" min="0" max="' . $this->playerArray[$player]->getChips() . '" 
                name="' . $player . '[' . $option . ']" value="0">';

            // Display Bet result with tooltip of original bet
            if (!$this->error) {
                $this->printTooltip($player, $option);
            }
            echo '</div>';
        }
        echo '<div class="betfield"></div><div class="betfield"><input type="hidden" name="time" value="' . time() . '"></div>';

        // Make a form input space for each number on the roulette wheel
        foreach ($this->wheelData as $num => $arr) {
            echo '<div class="betfield"><label for="'.$player.'[' . $num . ']">';
            if ($num < 10) {
                echo '<span class="transparent">0</span>';
            }
            echo '<span class="' . $arr['color'] . '">' . $num . ' </span></label>
                <input type="number" step="1" min="0" max="' . $this->playerArray[$player]->getChips() .
                '" name="' .$player.'[' . $num . ']" value="0">';

            // Display Bet result with tooltip of original bet
            if (!$this->error) {
                $this->printTooltip($player, $num);
            }
            echo '</div>';
        }
        echo "</div>";
    }

// Display Bet result with tooltip of original bet

    public function printTooltip(int $player, $inputType)
    {
        $originalBet = $this->playerArray[$player]->getBet($inputType) ?? null;
        $betResult = $this->playerArray[$player]->getLastResult($inputType) ?? null;
        if ($betResult) {
            echo '<label for="' . $player . '[' . $inputType . ']"' . 'class="betresult fadeinlate ';
            if ($betResult == 0) {
                echo 'transparent"> 00</label>';
            } elseif ($betResult < 0) {
                echo 'Red" tooltip="Your bet was ' . $originalBet . '"> ' . $betResult . '</label>';
            } elseif ($betResult > 0) {
                echo 'Green" tooltip="Your bet was ' . $betResult . '"> +' . $betResult . '</label>';
            }
        }
    }

    public function printErrorBox()
    {
        ?>
        <script>$.alert({
                title: "Oops!",
                content: "<?= $this->error ?>",
                boxWidth: "35vw",
                useBootstrap: false,
                theme: "Dark",
            });
        </script>

        <?php
    }

    public function printNameInputBox()
    {
        ?>
        <script>$.confirm({
                title: 'Optionally fill in your name(s) here before starting.',
                content: '' +
                '<form class="nameinput" name="nameinput" action="roulettepost" method="post"><br>' +
                '<div class="form-group">' +
                    '<label for="names[1]">Player 1 Name:  </label>' +
                    '<input type="text" name="names[1]" value="Player 1" class="namefield" maxlength="12" minlength="1" required />' +
                    '<br><br><label for="names[2]">Player 2 Name:  </label>' +
                    '<input type="text" name="names[2]" value="Player 2" class="namefield" maxlength="12" minlength="1" required />' +
                '</div>' +
                '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Start game!',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('.nameinput').submit();
                        }
                    },
                    cancel: function () {
                        //close
                    },
                },
                boxWidth: '35vw',
                useBootstrap: false,
                theme: 'Dark',
                });
        </script>

        <?php
    }

    /* SETTERS */

    public function setError($error): void
    {
        $this->error = $error;
    }

    public function getError(): string
    {
        return $this->error;
    }

}