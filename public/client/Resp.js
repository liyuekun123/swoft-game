/**响应服务器命令字处理类*/

var Resp = {  
       
    //获取
    getCard: function(data) {
        document.getElementById('msgText').innerHTML  += data + '\n';
    },
    
    //发送卡牌信息
    sendCard: function(data) {
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';			       
    },
    
    //翻牌信息
    turnCard: function(data) {	
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';	
    },
    
    //取消翻牌
    cancelCard: function(data) {			
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';		
    },
    
    //是否翻倍
    isDouble: function(data) {			
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';		
    },
    
    getSingerCard: function(data) {
       document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';		
    },
		
    chatMsg: function(data) {
       console.log('-------------------------------');
       console.log(data);
       //document.getElementById('msgText').innerHTML  += data["data"] + '\n';
       document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';
    },

    getSingerCard: function(data) {
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';
    },
    heartAsk: function(data) {
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';
    },
    loginFail: function(data) {
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';
        //跳转登陆页面
        document.location.href = "login";
    },
    broadcast: function(data) {
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';
    },
    joinRoom: function(data) {
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';
    },
    exitRoom: function(data) {
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';
    },
    roomNotify: function(data) {
        document.getElementById('msgText').innerHTML  += JSON.stringify(data) + '\n';
    },
}