<?php

namespace cosmicnebula200\SellMe\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use cosmicnebula200\SellMe\SellMe;
use cosmicnebula200\SellMe\Utils;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\CommandSender;
use pocketmine\item\StringToItemParser;
use pocketmine\player\Player;

class AllSubCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission('sellme.command.sell.all');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        $inv = $sender->getInventory();
        $amount = Utils::getAmount($inv->getItemInHand());
        if ($amount == 0)
        {
            $sender->sendMessage(SellMe::$messages->getMessage('sell.error'));
            return;
        }
        $itemInHand = $sender->getInventory()->getItemInHand();
        $alias = StringToItemParser::getInstance()->lookupAliases($itemInHand)[0];
        $nbt = $itemInHand->getNamedTag();
        $count = 0;
        foreach ($inv->getContents() as $slot => $item)
        {
            if (in_array($alias, StringToItemParser::getInstance()->lookupAliases($item)) and $item->getNamedTag() == $nbt)
            {
                Utils::sellItem($sender, $item);
                $count = $count + $item->getCount();
                $inv->setItem($slot, VanillaBlocks::AIR()->asItem());
            }
        }
        $totalAmount = $amount * $count;
        $sender->sendMessage(SellMe::$messages->getMessage('sell.all', [
            'item' => $itemInHand->getName(),
            'count' => $count,
            'amount' => $totalAmount
        ]));
    }

}
