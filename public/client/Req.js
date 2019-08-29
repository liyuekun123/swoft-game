/**发请求命令字处理类*/

var Req = {
    //定时器
    timer: 0,

    //发送心跳
    heartBeat: function (obj) {
        this.timer = setInterval(function () {
            if (obj.ws.readyState == obj.ws.OPEN) {
                var data = {};
                data['time'] = (new Date()).valueOf()
                obj.send(data, MainCmd.CMD_SYS, SubCmd.HEART_ASK_REQ);
            } else {
                clearInterval(this.timer);
            }
        }, 600000);
    },

    //获取卡牌信息
    GetCard: function (obj, data) {
        var data = {};
        obj.send(data, MainCmd.CMD_GAME, SubCmd.GET_CARD_REQ);
    },

    //发送卡牌信息
    SendCard: function (obj, data) {
        var data = {bet: 100};  //模拟数据
        obj.send(data, MainCmd.CMD_GAME, SubCmd.SEND_CARD_REQ);
    },

    //翻牌信息
    TurnCard: function (obj, data) {
        var data = {card: [], bet: 100}; //模拟数据
        obj.send(data, MainCmd.CMD_GAME, SubCmd.TURN_CARD_REQ);
    },

    //取消翻牌
    CancelCard: function (obj, data) {
        var data = {bet: 100}; //模拟数据
        obj.send(data, MainCmd.CMD_GAME, SubCmd.CANCEL_CARD_REQ);
    },

    //是否翻倍
    IsDouble: function (obj, data) {
        var data = {"card": 5, "pos": 2, "bean": 100, "bet": 100};
        obj.send(data, MainCmd.CMD_GAME, SubCmd.IS_DOUBLE_REQ);
    },

    //获取翻倍比较牌的大小
    GetSingerCard: function (obj, data) {
        var data = {};
        obj.send(data, MainCmd.CMD_GAME, SubCmd.GET_SINGER_CARD_REQ);
    },

    //聊天消息
    ChatMsg: function (obj, data) {
        var data = {data};
        obj.send(data, MainCmd.CMD_GAME, SubCmd.CHAT_MSG_REQ);
    },

    //加入房间
    JoinRoom: function (obj, data) {
        var data = {"roomid": 1};
        obj.send(data, MainCmd.CMD_GAME, SubCmd.JOIN_ROOM_REQ);
    },

    //退出房间
    ExitRoom: function (obj, data) {
        var data = {};
        obj.send(data, MainCmd.CMD_GAME, SubCmd.EXIT_ROOM_REQ);
    },

    //房间通信
    RoomNotify: function (obj, data) {
        var data = {"message": data};
        obj.send(data, MainCmd.CMD_GAME, SubCmd.ROOM_NOTIFY_REQ);
    },
}