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
	SellMe::getInstance()->getEconomyProvider()->addToMoney($player, $amount * $item->getCount(), [
		"item" => $item->getVanillaName(),
		"amount" => $item->getCount(),
	]);
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
    
    public static function addToPrices(Player $player, int $price, bool $overwrite = false): void
    {
        $item = $player->getInventory()->getItemInHand();
        if (!$overwrite){
            if (Utils::getAmount($item) !== 0) {
                $player->sendMessage(SellMe::$messages->getMessage(
                    'sell.error-adding',
                    [],
                    "The item already exits in prices, you can use '/sell overwrite' command to overwrite the price"
                ));
                return;
            }
        }
        if ($price <= 0)
        {
            $player->sendMessage(SellMe::$messages->getMessage(
                'sell.non-positive',
                [],
                "The price can not be a non positive integer"
            ));
            return;
        }
        $string = $item->getMeta() == 0 ? "{$item->getId()}" : "{$item->getId()}:{$item->getMeta()}";
        SellMe::$prices->setNested("prices.$string", $price);
        SellMe::$prices->save();
        SellMe::$prices->reload();
        $player->sendMessage(SellMe::$messages->getMessage(
            'sell.added',
            [
                'item' => $item->getName(),
                'amount' => $price
            ],
            'Added {ITEM} for {AMOUNT} to the list of prices'
        ));
    }
    
}
