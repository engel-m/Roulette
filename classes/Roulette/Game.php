<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/24/18
 * Time: 21:50
 */

namespace Roulette;

use OutOfRangeException;
use System\Session;


class Game
{
    protected $session;

    protected $wheel;

    protected $players = array();

    protected $approvedBets = array();

    protected $betResults = array(1 => array(), 2 => array());

    protected $expired = false;

    public $debug;


    public function __construct(object $wheel, array $playerEntries = [1 => 'Player 1', 2 => 'Player 2'])
    {
        $this->wheel = $wheel;
        $this->session = new Session();

        //Check to see if there are players + scores stored in the Session
        if (!empty($this->session->get('Players'))) {
            $this->players = $this->session->get('Players');
            $this->debug = 'got players';
        }
        // Else create new players according to entries (or default as seen above)
         else {
            foreach ($playerEntries as $playerId => $playerName) {
                $this->players[$playerId] = new Player($playerId, 1000, $playerName);
            }
        }
        // Check for session timeout
        if ($this->session->get('lastActivity')) {
            if ((time() - $this->session->get('lastActivity')) > 1800) {
                $this->expired = true;
            }
        }
    }

    /**
     * @param Player $player
     * @param array  $bet
     *
     * @throws OutOfRangeException  When the player has not enough chips
     */
    public function placeBets(array $incomingBets): void
    {
        //check Hidden submit time value
        if ($this->session->get('bettimestamp')) {
            if ($this->session->get('bettimestamp') == $incomingBets['time']) {
                throw new OutOfRangeException('You tried to resubmit your last betting round. Please enter new bets. :)');
            }
        }
        $this->session->set('bettimestamp', $incomingBets['time']);
        unset($incomingBets['time']);

        //Check for players trying to bet more chips than they have
        $faultedPlayers = '';
        foreach ($incomingBets as $player => $trybets) {
            if (array_sum($trybets) > $this->players[$player]->getChips()) {
                empty($faultedPlayers) ? $faultedPlayers = $this->players[$player]->getPlayerName() : $faultedPlayers .=
                    ' and ' . $this->players[$player]->getPlayerName();
            } else {
                $this->approvedBets[$player] = $trybets;
            }
        }
        if ($faultedPlayers) {
            $faultedPlayers .= ' bet more chips than available! Please try again without exceeding your chip amount!';
            throw new OutOfRangeException($faultedPlayers);
        }
    }

    public function calcResults()
    {
        $betArray = $this->approvedBets;
        $winning = $this->wheel->getSpinResults();

        foreach ($betArray as $player => $bets) {
            foreach ($bets as $key => $betAmount) {
                if ($key === $winning['number']) {
                    $this->betResults[$player][$key] = ($betAmount * 35);
                } else if (in_array($key, $winning, true)) {
                    $this->betResults[$player][$key] = ($betAmount * 1);
                }
                else {
                    $this->betResults[$player][$key] = ($betAmount * -1);
                }
            }
        $this->players[$player]->calcScore($betArray[$player], $this->betResults[$player]);
        }
        $this->savePlayers();
        $this->session->set('lastActivity', time());
    }


    /*GETTERS*/

    public function getSession(): object
    {
        return $this->session;
    }

    public function getPlayer(int $id): object
    {
        return $this->players[$id];
    }

    public function savePlayers()
    {
        $this->session->set('Players', $this->players);
    }

    public function getApprovedBets(): array
    {
        return $this->approvedBets;
    }

    public function getResults(): array
    {
        return $this->betResults;
    }

    public function getPlayersArray(): array
    {
        return $this->players;
    }

    public function isExpired(): bool
    {
        return $this->expired;
    }

}