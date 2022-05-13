<?php

namespace cosmicnebula200\SellMe\commands\subcommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use cosmicnebula200\SellMe\Utils;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class OverwriteSubCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission('sellme.command.sell.overwrite');
        $this->registerArgument(0, new IntegerArgument('price'));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        Utils::addToPrices($sender, $args['price'], true);
    }

}
