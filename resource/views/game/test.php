<!DOCTYPE html>  
<html>  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Testing swoole-h5game</title>  
</head>  
<body>  
    <form align=center>
    <h1>swoole-h5game Test工具</h1>  
    <div >  
        <tr>
          <td>服务器：</td>
          <td><input style="HEIGHT: 21px; WIDTH: 400px" size="17" id="url" value="ws://192.168.7.197:18308/game" ></td>
          <td><input style="HEIGHT: 20px; WIDTH: 97px" size="98" type="button" value="连接" id="ConnBt" onclick="do_conn()"></td>
        </tr>
    </div>
    <br>
    <div>  
       <textarea style="HEIGHT: 500px; WIDTH: 600px" rows="1" cols="1" readonly name="msgText" id="msgText"></textarea>
    </div> 
    <br>
    <div >  
        <tr>
            <td>昵称：</td>&nbsp;&nbsp;&nbsp;
            <td> <input style="HEIGHT: 21px; WIDTH: 200px" size="17" id="NickName" value="发现者" readonly></td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <td><input style="HEIGHT: 20px; WIDTH: 97px" size="98" type="button" value="清除数据" id="ClearBt" onclick="do_clear()"></td>&nbsp;&nbsp;&nbsp;
        </tr>
    </div>
    <br>
    <div>
		请求类型：<select id="req_cmd" style="HEIGHT: 21px; WIDTH: 100px">
			<option value="ChatMsg">ChatMsg</option>
			<option value="GetCard">getCard</option>
			<option value="SendCard">sendCard</option>
			<option value="TurnCard">turnCard</option>
			<option value="CancelCard">cancelCard</option>
			<option value="IsDouble">isDouble</option>
			<option value="GetSingerCard">getSingerCard</option>
		</select>

        请求数据：<input style="HEIGHT: 21px; WIDTH: 300px" size="17" id="SendText" value="send data test">&nbsp;
        <input style="HEIGHT: 20px; WIDTH: 97px" size="98" type="button" value="发送" name="SendBt" onclick="SendMsgText()">
    </div> 
    </form>
</body>
<script src="/client/Init.js?v12"></script>
<script src="/client/Const.js?v12"></script>
<script src="/client/Req.js?v12"></script>
<script src="/client/Resp.js?v12"></script>
<script src="/client/Packet.js?v12"></script>
<script src="/client/msgpack.js?v12"></script>

<script type="text/javascript" > 
	//请求消息框
    function do_clear(){
        document.getElementById('msgText').innerHTML = '';
    }
    
	//获取随机数
    function rnd(min,max){
        var tmp=min;
        if(max<min){min=max;max=tmp;}
        return Math.floor(Math.random()*(max-min+1)+min);
    }      
    

    var name = document.getElementById('NickName').value = '发现者-'+rnd(1000,9999);   
    var url = document.getElementById('url').value;
	
	//连接websocket
	function do_conn() {
		var url = document.getElementById('url').value;
		obj = Init.webSock(url);
		return obj;
	}
   
    //websocket        
	obj = do_conn();
    
	//发送消息函数
    function SendMsgText(){
		var func = document.getElementById('req_cmd').value; 
        var data = document.getElementById('SendText').value;
        if(data.length <= 0) return ;
		eval("Req."+func+"(obj, data)");              
    };
          
</script>  
</html> 