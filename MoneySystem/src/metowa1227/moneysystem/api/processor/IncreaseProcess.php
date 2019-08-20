<?php
namespace metowa1227\moneysystem\api\processor;

use pocketmine\Server;
use metowa1227\moneysystem\api\{
	core\API,
	listener\Types,
};
use metowa1227\moneysystem\event\money\{
    MoneyChangeEvent,
    MoneyIncreaseEvent,
};

class IncreaseProcess extends Processor implements Types
{
    /**
     * プレイヤーの所持金を増やす
     * Increase player's money
     *
     * @param Player | string | array  $player
     * @param int                      $money
     * @param string                   $reason
     * @param string                   $by [caller]
     * @param int                      $type
     * @param SQLiteDataManager        $db
     *
     * @return bool
    */
    public static function run($player, $money, $reason, $by, $type, $db) : bool
    {
        if (!API::getInstance()->exists($player)) {
            return false;
        }
        Server::getInstance()->getPluginManager()->callEvent($result = new MoneyChangeEvent($player, $money, $reason, $by, self::TYPE_INCREASE));
        Server::getInstance()->getPluginManager()->callEvent($result2 = new MoneyIncreaseEvent($player, $money, $reason, $by));
        if (!$result->isCancelled() && !$result2->isCancelled()) {
            $money = API::getInstance()->get($player) + $money;
            if ($money > MAX_MONEY) {
                $money = MAX_MONEY;
            }
            $db->file("UPDATE account SET money = $money WHERE name = \"$player\"");
            return true;
        }
        return false;
    }
}
