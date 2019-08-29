<?php


namespace App\WebSocket\Game\Logic;


use App\WebSocket\Game\Conf\MainCmd;
use App\WebSocket\Game\Conf\SubCmd;
use App\WebSocket\Game\Core\AStrategy;
use App\WebSocket\Game\Core\Packet;
use App\WebSocket\Game\Core\Room;
use App\WebSocket\GameModule;
use Swoft\Redis\Redis;

class ExitRoom extends AStrategy
{

    /**
     * 执行方法，每条游戏协议，实现这个方法就行
     */
    public function exec()
    {
        $fd_user_account_key = GameModule::FdAccountCacheKey($this->_params['fd']);
        $account = Redis::get($fd_user_account_key);
        $state = Room::ExitRoom($account);
        if ($state) {
            $res['result'] = "success";
        } else {
            $res['result'] = "fail";
        }
        $data = Packet::packFormat('OK', 0, $res);
        $data = Packet::packEncode($data, MainCmd::CMD_GAME, SubCmd::EXIT_ROOM_RESP);
        return $data;
    }
}