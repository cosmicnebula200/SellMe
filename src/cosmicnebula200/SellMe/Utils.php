<?php

namespace cosmicnebula200\SellMe;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;

class Utils
{

    public static function sellItem(Player $player, Item $item): bool
    {
        $amount = self::getAmount($item);
        if ($amount === 0)
        return false;
        SellMe::getInstance()->getEconomyProvider()->addToMoney($player, $amount * $item->getCount());
        return true;
    }

    public static function getAmount(Item $item): int
    {
        if (SellMe::$prices->getNested("prices.{$item->getId()}:{$item->getMeta()}") != false)
            return (int)SellMe::$prices->getNested("prices.{$item->getId()}:{$item->getMeta()}");
        if (SellMe::$prices->getNested("prices.{$item->getId()}") !== false)
            return (int)SellMe::$prices->getNested("prices.{$item->getId()}");
        return 0;
    }

    public static function getName(string $data): string
    {
        $id = explode(":", $data)[0] ?? $data;
        $meta = explode(":", $data)[1] ?? 0;
        $item = ItemFactory::getInstance()->get($id, $meta);
        return $item->getName();
    }
}
