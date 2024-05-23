<?php

namespace App\Helper\Ui;

class DiskSizeCalculator
{
    public static function getDiskSize()
    {
        $disktotal = disk_total_space('/'); //DISK usage
        $disktotalsize = round($disktotal / 1073741810, 2);

        $diskfree  = disk_free_space('/');
        $used = $disktotal - $diskfree;

        $diskusedize = round($used / 1073741810, 2);
        $diskuse1   = round(100 - (($diskusedize / $disktotalsize) * 100));
        $diskuse = round(100 - ($diskuse1));

        return $disksize = [
            compact(['diskuse', 'disktotalsize', 'diskusedize'])
        ];
    }
}
