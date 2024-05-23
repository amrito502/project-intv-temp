<?php

namespace App\Helper;

class Levels
{

    public static function all()
    {

        $levels = [
            [
                'id' => 1,
                'hand' => [
                    1 => 1,
                    2 => 1,
                    3 => 1,
                ],
                'bonus' => 36,
            ],
            [
                'id' => 2,
                'hand' => [
                    1 => 3,
                    2 => 3,
                    3 => 3,
                ],
                'bonus' => 90,
            ],
            [
                'id' => 3,
                'hand' => [
                    1 => 9,
                    2 => 9,
                    3 => 9,
                ],
                'bonus' => 216,
            ],
            [
                'id' => 4,
                'hand' => [
                    1 => 27,
                    2 => 27,
                    3 => 27,
                ],
                'bonus' => 486,
            ],
            [
                'id' => 5,
                'hand' => [
                    1 => 81,
                    2 => 81,
                    3 => 81,
                ],
                'bonus' => 972,
            ],

        ];

        // convert ranks to collection
        $levels = collect($levels);

        return $levels;

    }


}
