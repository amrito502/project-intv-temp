<?php

namespace App\Helper;

class Ranks
{

    public static function all()
    {

        $ranks = [
            // [
            //     'sl' => 0,
            //     'name' => 'Member',
            //     'requirements' => [
            //         1 => 100,
            //         2 => 100,
            //         3 => 100,
            //     ],
            //     'achivement' => 0,
            //     'rank_bonus_table' => false,
            // ],
            [
                'sl' => 1,
                'name' => 'Executive',
                'requirements' => [
                    1 => 500,
                    2 => 500,
                    3 => 500,
                ],
                'achivement' => 48,
                'rank_bonus_table' => 'executive_bonus_status',
            ],
            [
                'sl' => 2,
                'name' => 'Sr. Executive',
                'requirements' => [
                    1 => 2500,
                    2 => 2500,
                    3 => 2500,
                ],
                'achivement' => 37,
                'rank_bonus_table' => 'sr_executive_status_bonus',
            ],
            [
                'sl' => 3,
                'name' => 'Asst. Manager',
                'requirements' => [
                    1 => 22500,
                    2 => 22500,
                    3 => 22500,
                ],
                'achivement' => 25,
                'rank_bonus_table' => 'asst_manager_bonus_status',
            ],
            [
                'sl' => 3,
                'name' => 'Manager',
                'requirements' => [
                    1 => 122500,
                    2 => 122500,
                    3 => 122500,
                ],
                'achivement' => 20,
                'rank_bonus_table' => 'manager_bonus_status',
            ],
            [
                'sl' => 4,
                'name' => 'AGM',
                'requirements' => [
                    1 => 622500,
                    2 => 622500,
                    3 => 622500,
                ],
                'achivement' => 10,
                'rank_bonus_table' => 'agm_bonus_status',
            ],
            [
                'sl' => 5,
                'name' => 'GM',
                'requirements' => [
                    1 => 1622500,
                    2 => 1622500,
                    3 => 1622500,
                ],
                'achivement' => 6,
                'rank_bonus_table' => 'gm_bonus_status',
            ],
            [
                'sl' => 6,
                'name' => 'ED',
                'requirements' => [
                    1 => 6622500,
                    2 => 6622500,
                    3 => 6622500,
                ],
                'achivement' => 2,
                'rank_bonus_table' => 'ed_bonus_status',
            ],
        ];

        // convert ranks to collection
        $ranks = collect($ranks);

        return $ranks;

    }


}
