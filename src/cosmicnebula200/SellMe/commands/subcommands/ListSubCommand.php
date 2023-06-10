<?php

namespace cosmicnebula200\SellMe\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use cosmicnebula200\SellMe\SellMe;
use cosmicnebula200\SellMe\Utils;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use Vecnavium\FormsUI\CustomForm;

class ListSubCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission('sellme.command.sell.list');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        $form = new CustomForm(function (Player $player, array|null $data): void {
            if ($data === null)
                return;
        });
        foreach (SellMe::$prices->getNested('prices') as $item => $price) {
            $search = [
                '{ITEM}',
                '{PRICE}'
            ];
            $replace = [
                $item,
                $price
            ];
            $label = str_replace($search, $replace, SellMe::$forms->getNested('sell-list.label', '&7[&a*&7]&e {ITEM} &e: &a{PRICE}'));
            $label = TextFormat::colorize($label);
            $form->addLabel($label);
        }
        $form->setTitle(TextFormat::colorize(SellMe::$forms->getNested('sell-list.title' , '&l&dSell List')));
        $form->sendToPlayer($sender);
    }

}
