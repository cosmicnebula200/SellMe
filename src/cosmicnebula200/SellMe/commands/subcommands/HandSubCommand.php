<?php

namespace cosmicnebula200\SellMe\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use cosmicnebula200\SellMe\SellMe;
use cosmicnebula200\SellMe\Utils;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class HandSubCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission('sellme.subcommand.hand');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        $item = $sender->getInventory()->getItemInHand();
        if (!Utils::sellItem($sender, $item))
        {
            $sender->sendMessage(SellMe::$messages->getMessage('sell.error'));
            return;
        }
        $sender->sendMessage(SellMe::$messages->getMessage('sell.hand', [
            'item' => $item->getName(),
            'count' => $item->getCount(),
            'amount' => Utils::getAmount($item) * $item->getCount()
        ]));
        $sender->getInventory()->setItemInHand(VanillaBlocks::AIR()->asItem());
    }

}
