<?php

namespace cosmicnebula200\SellMe\provider;

use pocketmine\player\Player;

interface EconomyProvider
{

    public function getName(): string;

    public function checkClass(): bool;

    public function addToMoney(Player $player, int $amount, array $labels): void;

}
