<?php

namespace cosmicnebula200\SellMe\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use cosmicnebula200\SellMe\SellMe;
use cosmicnebula200\SellMe\Utils;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use Vecnavium\FormsUI\SimpleForm;

class CheckSubCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission('sellme.command.sell.check');
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if (!$sender instanceof Player)
            return;
        $form = new SimpleForm(function (Player $player, ?int $data): void {
            if ($data === null)
                return;
            $price = 0;
            $inv = $player->getInventory();
            switch ($data)
            {
                case 0:
                    $item = $player->getInventory()->getItemInHand();
                    $price = Utils::getAmount($item) * $item->getCount();
                    break;
                case 1:
                    $amount = Utils::getAmount($inv->getItemInHand());
                    if ($amount == 0)
                        break;
                    $id = $inv->getItemInHand()->getId();
                    $meta = $inv->getItemInHand()->getMeta();
                    $count = 0;
                    foreach ($inv->getContents() as  $item)
                    {
                        if ($item->getId() == $id and $item->getMeta() == $meta)
                            $count = $count + $item->getCount();
                    }
                    $price = $amount * $count;
                    break;
                case 2:
                    foreach ($inv->getContents() as $item)
                    {
                        if (Utils::getAmount($item) !== 0)
                        {
                            $price += (Utils::getAmount($item) * $item->getCount());
                        }
                    }
                    break;
            }
            $player->sendMessage(SellMe::$messages->getMessage(
                "sell.check",
                [
                    "type" => match ($data) {
                        0 => "Hand",
                        1 => "All similar items as hand",
                        2 => "Inventory"
                    },
                    "amount" => $price
                ]
            ));
        });
        $form->setTitle(TextFormat::colorize(SellMe::$forms->getNested('check-form.title', '&l&dCheck Form')));
        $form->addButton(TextFormat::colorize(SellMe::$forms->getNested('check-form.hand' , '&l&dCheck Hand')));
        $form->addButton(TextFormat::colorize(SellMe::$forms->getNested('check-form.all' , '&l&dCheck All')));
        $form->addButton(TextFormat::colorize(SellMe::$forms->getNested('check-form.inv' , '&l&dCheck Inv')));
        $form->sendToPlayer($sender);
    }

}
