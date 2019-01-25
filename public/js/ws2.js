
var ws;

var room_id = 1;

var currUser = 10;

ws = new WebSocket("ws://127.0.0.1:1215");
ws.onopen = function (evt) {
//    发送房间号相关信息，以识别connect id
    var data = {
        room_id: room_id,
        user_id: currUser,
        type: 'connect'
    };
    console.log('连接成功');
    ws.send(JSON.stringify(data));
};

var send = function (e) {
    var data = {
        'message': $('.wait-send').val(),
        'user_id': currUser,
        'room_id': room_id,
        'type': 'message'
    };
    ws.send(JSON.stringify(data));
    //清空数据
    $('.wait-send').val('');

};

$(document).ready(function(){

    $('#send2').click(function (e) {
        console.log('发送成功!');
        // send(e);
        ws.send();
    });


});






