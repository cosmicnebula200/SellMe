<?php

namespace cosmicnebula200\SellMe\commands\subcommands;

use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use cosmicnebula200\SellMe\Utils;
use JsonException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class AddSubCommand extends BaseSubCommand
{

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->setPermission('sellme.command.sell.add');
        $this->registerArgument(0, new IntegerArgument('price'));
    }

    /**
     * @throws JsonException
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        Utils::addToPrices($sender, $args['price']);
    }

}
