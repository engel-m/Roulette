<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 7/24/18
 * Time: 14:49
 */

namespace Roulette;
use Exception;


class Wheel
{
    const GREEN = 'Green';
    const BLACK = 'Black';
    const RED   = 'Red';

    const ODD   = 'Odd';
    const EVEN  = 'Even';

    const RANGE_1_18  = '1to18';
    const RANGE_19_36 = '19to36';

    const NONE = 'None';

    protected static $wheelArray = array(
        0 => ['color' => Wheel::GREEN, 'type' => Wheel::NONE, 'range' => Wheel::NONE],
        1 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_1_18],
        2 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_1_18],
        3 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_1_18],
        4 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_1_18],
        5 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_1_18],
        6 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_1_18],
        7 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_1_18],
        8 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_1_18],
        9 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_1_18],
        10 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_1_18],
        11 => ['color' => Wheel::BLACK, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_1_18],
        12 => ['color' => Wheel::RED, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_1_18],
        13 => ['color' => Wheel::BLACK, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_1_18],
        14 => ['color' => Wheel::RED, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_1_18],
        15 => ['color' => Wheel::BLACK, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_1_18],
        16 => ['color' => Wheel::RED, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_1_18],
        17 => ['color' => Wheel::BLACK, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_1_18],
        18 => ['color' => Wheel::RED, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_1_18],
        19 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_19_36],
        20 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_19_36],
        21 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_19_36],
        22 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_19_36],
        23 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_19_36],
        24 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_19_36],
        25 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_19_36],
        26 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_19_36],
        27 => ['color' => Wheel::RED, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_19_36],
        28 => ['color' => Wheel::BLACK, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_19_36],
        29 => ['color' => Wheel::BLACK, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_19_36],
        30 => ['color' => Wheel::RED, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_19_36],
        31 => ['color' => Wheel::BLACK, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_19_36],
        32 => ['color' => Wheel::RED, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_19_36],
        33 => ['color' => Wheel::BLACK, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_19_36],
        34 => ['color' => Wheel::RED, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_19_36],
        35 => ['color' => Wheel::BLACK, 'type' => Wheel::ODD, 'range' => Wheel::RANGE_19_36],
        36 => ['color' => Wheel::RED, 'type' => Wheel::EVEN, 'range' => Wheel::RANGE_19_36],
    );

    protected $spinResults = array();


    public function spin()
    {
        try {
            $number = random_int(0, 36);
        } catch (Exception $e) {
            $number = mt_rand(0,36);
        }
        $this->spinResults = array('number' => $number,
                                    'color' => self::$wheelArray[$number]['color'],
                                    'type' => self::$wheelArray[$number]['type'],
                                    'range' => self::$wheelArray[$number]['range']);
    }

    /*GETTERS*/

    public function getSpin(string $input): ?string
    {
        return $this->spinResults[$input] ?? null;
    }

    public function getSpinResults(): array
    {
        return $this->spinResults;
    }

    public static function getWheelArray(): array
    {
        return self::$wheelArray;
    }

}
