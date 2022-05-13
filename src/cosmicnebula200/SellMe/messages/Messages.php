<?php

namespace cosmicnebula200\SellMe\messages;

use cosmicnebula200\SellMe\SellMe;
use pocketmine\utils\TextFormat;

class Messages
{

    public function getMessage(string $msg, array $args = [], string $default = ''): string
    {
        $message = SellMe::$messageConfig->getNested("messages.$msg", $default);
        foreach ($args as $key => $value)
            $message = str_replace('{' . strtoupper($key) . '}', $value, $message);
        return  TextFormat::colorize(SellMe::$messageConfig->get('prefix') . SellMe::$messageConfig->get('seperator') ."$message");
    }

}
