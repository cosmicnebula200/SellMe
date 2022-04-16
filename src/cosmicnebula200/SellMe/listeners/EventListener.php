<?php

namespace cosmicnebula200\SellMe\listeners;

use cosmicnebula200\SellMe\SellMe;
use cosmicnebula200\SellMe\Utils;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class EventListener implements Listener
{

    /**
     * @param PlayerJoinEvent $event
     * @return void
     */
    public function onJoin(PlayerJoinEvent $event): void
    {
        SellMe::$autosell[$event->getPlayer()->getName()] = 0;
    }

    /**
     * @param PlayerQuitEvent $event
     * @return void
     */
    public function onLeave(PlayerQuitEvent $event): void
    {
        unset(SellMe::$autosell[$event->getPlayer()->getName()]);
    }

    /**
     * @param BlockBreakEvent $event
     * @return void
     */
    public function onBlockBreak(BlockBreakEvent $event): void
    {
        if (SellMe::$autosell[$event->getPlayer()->getName()])
        {
            $drops = $event->getDrops();
            foreach ($event->getDrops() as $key => $drop)
            {
                if (Utils::sellItem($event->getPlayer(), $drop))
                    unset($drops[$key]);
            }
            $event->setDrops($drops);
        }
    }

}
