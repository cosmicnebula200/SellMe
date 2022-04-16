# SellMe
The Ultimate Sell plugin for PocketMine-MP 4

**What is SellMe?**
- SellMe is a plugin which allows the items to be sold in exchange with money

# Features
The currently offered features are as follows
- Multiple Economy providers like EconomyAPI, BedrockEconomy and Capital
- AutoSell 
- Item meta checks
- Multiple sell modes (hand, all, inv)

# Permissions
```
  sellme.command.sell:
    default: true
    description: with this permission the player can use the sell command
  sellme.subcommand.hand:
    default: true
    description: with this permission the player sell his/her hand
  sellme.subcommand.all:
    default: true
    description: with this permission the player sell all items in his/her inv which are similar to his current item in hand
  sellme.subcommand.inv:
    default: true
    description: with this permission the player can sell his/her inventory
  sellme.command.autosell:
    default: true
    description: with this permission the player can toggle his autosell status
```

# Commands
Command | Description | Permission | Aliases |
----------------- | ------------- | ------------- | -------- |
Sell | Sell command | sellme.command.sell | |
AutoSell | AutoSell command | sellme.command.autosell | AS |

# SubCommands

**SELL**

SubCommand | Description | Permission | Aliases |
----------------- | ------------- | ------------- | -------- |
Hand | sells the item which is held by the user  | sellme.subcommand.hand | h |
all | sells the items in inventory which are similar to the one in the users hands | sellme.subcommand.all | a |
inv | sells all the items in the inventory of the user | sellme.subcommand.hand | i, inventory |