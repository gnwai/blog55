

// 连接服务端，workerman.net:2120换成实际部署web-msg-sender服务的域名或者ip
var socket = io();


// uid可以是自己网站的用户id，以便针对uid推送以及统计在线人数
uid = 123;
// socket连接后以uid登录
socket.on('connect', function(){
    // socket.emit('example', uid);
    console.log('connect ok');
});

// 后端推送来消息时
// socket.on('new_msg', function(msg){
//     console.log("收到消息："+msg);
// });
// // 后端推送来在线数据时
// socket.on('update_online_count', function(online_stat){
//     console.log(online_stat);
// });


$(document).ready(function(){

    $('#send2').click(function (e) {
        console.log('发送成功!');
        // send(e);
        socket.emit('example', $('.wait-send').val());
    });


});