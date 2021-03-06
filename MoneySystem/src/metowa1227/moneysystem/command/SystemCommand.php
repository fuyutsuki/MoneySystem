<?php
namespace metowa1227\moneysystem\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use metowa1227\moneysystem\api\core\API;

/**
 * '/moneysystem'コマンド
 */
class SystemCommand extends Command
{
    public function __construct()
    {
        parent::__construct("moneysystem", "MoneySystem information", "/moneysystem");
        $this->setPermission("moneysystem.system.info");
    }

    public function execute(CommandSender $sender, string $label, array $args) : bool
    {
        for ($i = 0; $i <= 4; $i++) {
            $sender->sendMessage(API::getInstance()->getMessage("command.system-guide-" . $i));
        }
        return true;
    }
}
