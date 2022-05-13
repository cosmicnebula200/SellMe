<?php

namespace cosmicnebula200\SellMe\commands;

use CortexPE\Commando\BaseCommand;
use cosmicnebula200\SellMe\commands\subcommands\AllSubCommand;
use cosmicnebula200\SellMe\commands\subcommands\HandSubCommand;
use cosmicnebula200\SellMe\commands\subcommands\InvSubCommand;
use cosmicnebula200\SellMe\commands\subcommands\ListSubCommand;
use cosmicnebula200\SellMe\SellMe;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use Vecnavium\FormsUI\SimpleForm;

class SellCommand extends BaseCommand
{

    protected function prepare(): void
    {
        $this->setPermission(
            'sellme.command.sell.hand;'.
            'sellme.command.sell.all;'.
            'sellme.command.sell.inv;'.
            'sellme.command.sell.list'
        );
        $this->registerSubCommand(new HandSubCommand('hand', 'sells the item which is held by the user', ['h']));
        $this->registerSubCommand(new AllSubCommand('all', 'sells the items in inventory which are similar to the one in the users hands', ['a']));
        $this->registerSubCommand(new InvSubCommand('inv', 'sells all the items in the inventory of the user', ['inventory', 'i']));
        $this->registerSubCommand(new ListSubCommand('list', 'View available items/prices', ['l']));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        $form = new SimpleForm(function (Player $player, int|null $data): void {
            if ($data === null)
                return;
            $command = match ($data)
            {
                0 => 'hand',
                1 => 'all',
                2 => 'inv',
                3 => 'list'
            };
            SellMe::getInstance()->getServer()->dispatchCommand($player, "sell $command");
        });
        $form->setTitle(TextFormat::colorize(SellMe::$forms->getNested('sell-form.title' , '&l&dSell Form')));
        if($sender->hasPermission('sellme.command.sell.hand')){
           $form->addButton(TextFormat::colorize(SellMe::$forms->getNested('sell-form.hand' , '&l&dSell Hand')));
        }
        if($sender->hasPermission('sellme.command.sell.all')){
            $form->addButton(TextFormat::colorize(SellMe::$forms->getNested('sell-form.all' , '&l&dSell All')));
        }
        if($sender->hasPermission('sellme.command.sell.inv')){
            $form->addButton(TextFormat::colorize(SellMe::$forms->getNested('sell-form.inv' , '&l&dSell Inv')));
        }
        if($sender->hasPermission('sellme.command.sell.list')){
            $form->addButton(TextFormat::colorize(SellMe::$forms->getNested('sell-form.list' , '&l&dSell List')));
        }
        $form->sendToPlayer($sender);

    }

}
