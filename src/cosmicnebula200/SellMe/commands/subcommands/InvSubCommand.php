<?php

namespace cosmicnebula200\SellMe\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use cosmicnebula200\SellMe\SellMe;
use cosmicnebula200\SellMe\Utils;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class InvSubCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission('sellme.subcommand.inv');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        $inv = $sender->getInventory();
        $amount = 0;
        foreach ($inv->getContents() as $slot => $item)
        {
            if (Utils::getAmount($item) === 0)
                continue;
            Utils::sellItem($sender, $item);
            $amount += Utils::getAmount($item) * $item->getCount();
            $inv->setItem($slot, VanillaBlocks::AIR()->asItem());
        }
        $sender->sendMessage(SellMe::$messages->getMessage('sell.inv',[
            'amount' => $amount
        ]));
    }

}
