<?php

namespace cosmicnebula200\SellMe\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use cosmicnebula200\SellMe\SellMe;
use cosmicnebula200\SellMe\Utils;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\CommandSender;
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
        $vanillaName = $inv->getItemInHand()->getVanillaName();
        $count = 0;
        foreach ($inv->getContents() as $slot => $item)
        {
            if ($item->getVanillaName() === $vanillaName)
            {
                Utils::sellItem($sender, $item);
                $count = $count + $item->getCount();
                $inv->setItem($slot, VanillaBlocks::AIR()->asItem());
            }
        }
        $totalAmount = $amount * $count;
        $sender->sendMessage(SellMe::$messages->getMessage('sell.all', [
            'item' => $vanillaName,
            'count' => $count,
            'amount' => $totalAmount
        ]));
    }

}
