<?php

namespace cosmicnebula200\SellMe\provider;

use cosmicnebula200\SellMe\SellMe;
use pocketmine\player\Player;
use SOFe\Capital\Capital;
use SOFe\Capital\CapitalException;
use SOFe\Capital\LabelSet;
use SOFe\Capital\Schema\Complete;

class CapitalEconomyProvider extends EconomyProvider
{

    /** @var Complete */
    private Complete $selector;

    public function __construct()
    {
        Capital::api("0.1.0", function(Capital $api) {
            $this->selector = $api->completeConfig(SellMe::getInstance()->getConfig()->getNested("capital-settings.selector"));
        });
    }

    public function getName(): string
    {
        return "Capital";
    }

    public function checkClass(): bool
    {
        if (class_exists(Capital::class))
            return true;
        return false;
    }

    public function addToMoney(Player $player, int $amount): void
    {
        Capital::api('0.1.0',
            function ($api) use ($player, $amount)
            {
                try {
                    yield from $api->addMoney(
                        "SellMe",
                        $player,
                        $this->selector,
                        $amount,
                        new LabelSet(["reason" => "selling items"]),
                    );
                }catch (CapitalException){

                }
            });
    }

}
