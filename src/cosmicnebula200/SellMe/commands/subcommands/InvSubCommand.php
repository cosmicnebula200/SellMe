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
        $this->setPermission('sellme.command.sell.inv');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        $inv = $sender->getInventory();
        $amount = 0;
        foreach ($inv->getContents() as $index => $item)
        {
            if (Utils::getAmount($item) !== 0)
            {
                $amount += (Utils::getAmount($item) * $item->getCount());
                $inv->setItem($index, VanillaBlocks::AIR()->asItem());
            }
        }
        if ($amount == 0)
        {
            $sender->sendMessage(SellMe::$messages->getMessage('sell.error'));
            return;
        }
        $sender->sendMessage(SellMe::$messages->getMessage('sell.inv',[
            'amount' => $amount
        ]));
	SellMe::getInstance()->getEconomyProvider()->addToMoney($sender, $amount, [
		"item" => "all",
	]);
    }

}
