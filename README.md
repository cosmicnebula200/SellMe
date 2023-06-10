# SellMe
The Ultimate Sell plugin for PocketMine-MP 5

**What is SellMe?**
- SellMe is a plugin which allows the items to be sold in exchange with money

# Features
The currently offered features are as follows
- Multiple Economy providers like EconomyAPI, BedrockEconomy and Capital
- AutoSell 
- Item meta checks
- Multiple sell modes (hand, all, inv)
- List command which shows the list of all the prices of items.
-  Check command which allows you to check the price of the items in your inventory.
- Add command which allows you to add items to the price list.
- Overwrite command which allows you to modify any item which is currently in the price list.

# Permissions
```
permissions:
  sellme.command.sell.hand:
    default: true
    description: with this permission the player sell his/her hand
  sellme.command.sell.all:
    default: true
    description: with this permission the player sell all items in his/her inv which are similar to his current item in hand
  sellme.command.sell.inv:
    default: true
    description: with this permission the player can sell his/her inventory
  sellme.command.sell.list:
    default: true
    description: with this permission the player can view sell listing
  sellme.command.sell.add:
    default: op
    description: with this permission the player can add items to the sell prices
  sellme.command.sell.overwrite:
    default: op
    description: with this permission the player can overwrite the prices of the items from the list of prices
  sellme.command.sell.check:
    default: true
    description: with this permission the player can view the price of the items in their inventory
  sellme.command.autosell:
    default: true
    description: with this permission the player can toggle his autosell status
```

# Commands
Command | Description | Permission | Aliases |
----------------- | ------------- | ------------- | -------- |
`Sell` | Sell command | sellme.command.sell | |
`AutoSell` | AutoSell command | sellme.command.autosell | AS |

# SubCommands

**SELL**

SubCommand | Description                                                             | Permission                | Aliases      |
----------------- |-------------------------------------------------------------------------|---------------------------|--------------|
`Hand` | Sells the item which is held by the user | sellme.command.sell.hand  | h |
`All` | Sells the items in inventory which are similar to the one in the users hands | sellme.command.sell.all   | a |
`Inv` | Sells all the items in the inventory of the user  | sellme.command.sell.hand  | i, inventory |
`List` | View available items/prices | sellme.command.sell.list  | l |
`Check` | Checks the amount that you can receive after using the sell command | sellme.command.sell.check | c |
`Add` | Adds the item in hand to the list of current prices | sellme.command.sell.add | |
`Overwrite` | Overwrites the item price in the list of current prices | sellme.command.sell.overwrite ||
