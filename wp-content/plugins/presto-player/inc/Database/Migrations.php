<?php

namespace PrestoPlayer\Database;

use PrestoPlayer\Database\Videos;
use PrestoPlayer\Database\Visits;
use PrestoPlayer\Database\Presets;
use PrestoPlayer\Database\EmailCollection;
use PrestoPlayer\Database\Upgrades\Upgrades;
use PrestoPlayer\Database\Upgrades\PerformanceUpgrade;

class Migrations
{
    public static function run()
    {
        // order of this one is important
        $performance = new PerformanceUpgrade();
        $performance->migrate();

        $visits = new Visits(new Table());
        $visits->install();

        $presets = new Presets(new Table());
        $presets->install();

        $videos = new Videos(new Table());
        $videos->install();
         
        $videos = new EmailCollection(new Table());
        $videos->install();

        $upgrades = new Upgrades();
        $upgrades->migrate();
    }

    public static function remove()
    {
        $visits = new Visits(new Table());
        $visits->uninstall();

        $presets = new Presets(new Table());
        $presets->uninstall();

        $videos = new Videos(new Table());
        $videos->uninstall();
    }
}
