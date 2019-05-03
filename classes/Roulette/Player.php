<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/24/18
 * Time: 21:46
 */

namespace Roulette;


class Player
{
    protected $playerName = 'Anonymous Player';

    protected $playerId = 1;

    protected $chips = 1000;

    protected $lastBets = array();

    protected $lastResults = array();

    protected $lastTotal = 0;


    public function __construct(int $id = 1, int $chips = 1000, string $name = 'Anonymous Player')
    {
        $this->playerId = $id;
        $this->chips = $chips;
        $this->playerName = $name;
    }

    private function calcLastTotal(): void
    {
        $this->lastTotal = array_sum($this->lastResults);
        $this->chips = $this->chips + $this->lastTotal;
    }

    public function calcScore(array $playerBetArray, array $playerResultArray): void
    {
        $this->lastBets = $playerBetArray;
        $this->lastResults = $playerResultArray;
        $this->calcLastTotal();
    }


    /*GETTERS*/
    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    public function getChips(): int
    {
        return $this->chips;
    }

    public function getBet($key)
    {
        return $this->lastBets[$key] ?? null;
    }

    public function getLastTotal(): int
    {
        return $this->lastTotal;
    }

    public function getLastResult($betSlot): ?int
    {
        return $this->lastResults[$betSlot] ?? null;
    }

    public function getLastResults(): array
    {
        return $this->lastResults;
    }

    /* SETTERS*/

}