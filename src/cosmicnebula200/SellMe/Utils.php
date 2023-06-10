<?php

namespace cosmicnebula200\SellMe;

use pocketmine\item\Item;
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
        if (SellMe::$prices->getNested("prices.{$item->getVanillaName()}") !== false)
            return (int)SellMe::$prices->getNested("prices.{$item->getVanillaName()}");
        return 0;
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
        SellMe::$prices->setNested("prices.{$item->getVanillaName()}", $price);
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
