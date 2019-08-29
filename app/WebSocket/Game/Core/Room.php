<?php declare(strict_types=1);

namespace App\WebSocket\Game\Core;


use App\WebSocket\GameModule;
use Swoft\Redis\Redis;
use Swoft\WebSocket\Server\WebSocketServer;

class Room
{
    const EXPIRE = 24 * 60 * 60;

    public static function CacheKeyRoomMember($roomId): string
    {
        return "ROOM_{$roomId}_MEMBER";
    }

    public static function CacheKeyAccountRoomId($account): string
    {
        return "ROOM_ID_{$account}";
    }

    /**
     * 加入房间
     *
     * @param $account
     * @param $roomId
     * @return array
     */
    public static function JoinRoom($account, $roomId)
    {
        $roomCacheKey = self::CacheKeyRoomMember($roomId);
        $data = Redis::get($roomCacheKey);
        $add = false;
        if (!empty($data)) {
            if (!in_array($account, $data)) {
                $data[] = $account;
                $add = true;
            }
        } else {
            $data = [$account];
            $add = true;
        }
        if ($add) {
            Redis::set($roomCacheKey, $data, self::EXPIRE);
            $roomIdKey = self::CacheKeyAccountRoomId($account);
            Redis::set($roomIdKey, $roomId, self::EXPIRE);
        }
        return $data;
    }

    /**
     * 退出房间
     * @param $account
     * @return boolean
     */
    public static function ExitRoom($account)
    {
        $result = false;
        $roomIdKey = self::CacheKeyAccountRoomId($account);
        $roomId = Redis::get($roomIdKey);
        if (!empty($roomId)) {
            $roomCacheKey = "ROOM_{$roomId}_MEMBER";
            $data = Redis::get($roomCacheKey);
            if (!empty($data)) {
                $key = array_search($account, $data);
                if ($key !== false) {
                    unset($data[$key]);
                    $result = true;
                    if (!empty($data)) {
                        Redis::set($roomCacheKey, $data, self::EXPIRE);
                        Redis::del($roomIdKey);
                    } else {
                        Redis::del($roomCacheKey);
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 发送消息给其它成员
     *
     * @param $account
     * @param $msg
     * @param $fd
     * @param WebSocketServer $server
     */
    public static function SendToRoomMembers($account, $msg, $fd, $server)
    {
        $roomIdKey = self::CacheKeyAccountRoomId($account);
        $roomId = Redis::get($roomIdKey);
        if (!empty($roomId)) {
            $roomCacheKey = "ROOM_{$roomId}_MEMBER";
            $data = Redis::get($roomCacheKey);
            //Log::show("SendToRoomMembers_ROOM_MEMBERS:" . print_r($data, true));
            if (!empty($data)) {
                $fdArr = array();
                foreach ($data as $memAccount) {
                    if ($memAccount == $account) {
                        continue;
                    }
                    $user_info_key = sprintf(GameModule::USER_INFO_KEY, $memAccount);
                    $userInfo = Redis::get($user_info_key);
                    //Log::show("$memAccount userInfo" . $userInfo);
                    $uinfo = json_decode($userInfo, true);
                    if (!empty($uinfo) && isset($uinfo['fd'])) {
                        $fdArr[] = $uinfo['fd'];
                    }
                }
                Log::show("SendToRoomMembers_FD_ARR:" . implode(',', $fdArr));
                if (!empty($fdArr)) {
                    server()->sendToSome($msg, $fdArr, [], $fd, 50, WEBSOCKET_OPCODE_BINARY);
                }
            }
        }
    }
}