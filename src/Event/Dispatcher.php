<?php
/**
 * Created by PhpStorm.
 * User: droxy
 * Date: 02/12/15
 * Time: 07:34
 */

namespace ORM\Event;



class Dispatcher
{
    static $_event = [];

    static function addEventListener($event, $callback)
    {
        self::$_event[$event][] = $callback;
    }

    static function execEvent($event)
    {
        $events = (!empty(self::$_event[$event])) ? self::$_event[$event] : [];
        foreach($events as $event) {
            $event();
        }
    }
}