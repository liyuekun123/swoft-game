<?php


namespace App\WebSocket\Game\Logic;


use App\WebSocket\Game\Conf\MainCmd;
use App\WebSocket\Game\Conf\SubCmd;
use App\WebSocket\Game\Core\AStrategy;
use App\WebSocket\Game\Core\Packet;
use App\WebSocket\Game\Core\Room;
use App\WebSocket\GameModule;
use Swoft\Redis\Redis;

class RoomNotify extends AStrategy
{

    /**
     * 执行方法，每条游戏协议，实现这个方法就行
     */
    public function exec()
    {
        $fd_user_account_key = GameModule::FdAccountCacheKey($this->_params['fd']);
        $account = Redis::get($fd_user_account_key);
        if (isset($this->_params['data']['message'])) {
            $notifyData = Packet::packFormat('OK', 0, ['data' => $this->_params['data']['message']]);
            $notifyData = Packet::packEncode($notifyData, MainCmd::CMD_GAME, SubCmd::CHAT_MSG_RESP);
            Room::SendToRoomMembers($account, $notifyData, $this->_params['fd'], $this->_params['serv']);
        }
        $res['account'] = $account;
        $res['message'] = $this->_params['data']['message'];
        $data = Packet::packFormat('OK', 0, $res);
        $data = Packet::packEncode($data, MainCmd::CMD_GAME, SubCmd::ROOM_NOTIFY_RESP);
        return $data;
    }
}