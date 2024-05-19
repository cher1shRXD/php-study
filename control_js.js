var Home = "./index.php";
var search_Page = "./search.php";
var profile = "./profile_Page.php";
var making_Page = "./make.php";
var login_Page = "./login.php";
var logout = "./logout.php";
var refresh_info = "./refresh_info.php";
var edit_info = "edit_info.php";

function GoBack() {
    history.go(-1);
}
function Reloading() {
    location.reload();
}
function GoHome() {
    location.replace(Home);
}
function GoSearch() {
    location.href = search_Page;
}
function GoProfile() {
    location.href = profile;
}
function GoMake() {
    location.href = making_Page;
}
function Log_in() {
    location.href = login_Page;
}
function log_out() {
    location.href = logout;
}
function info_refreshing() {
location.href = refresh_info;
}
function info_editing() {
    location.href = edit_info;
}
var idleTime = 0;
function timerIncrement() {
    idleTime = idleTime + 1;
    // 20분이상 움직임이 없으면 새로고침 & 경로이동
    if (idleTime > 4) { 
        window.location.reload();
    }
}
function like(e) {
    var like_post = e.getAttribute('id');
    var liker = e.getAttribute('alt');
    var like_src = e.getAttribute('src');
    var post_writer = e.getAttribute('class').split(' ')[1];
    var like_id = like_post + 'like';
    if(like_src == './like_no.svg') {
        $.post('./like_ok.php', {like_clicker : liker, writer : post_writer, liked_post : like_post, check_like : 'be_like'})
            .done(function(){
                if(document.getElementById(like_id).innerText != '99+') {
                    document.getElementById(like_id).innerText = Number(document.getElementById(like_id).innerText) + 1;
                }
                e.src = './like_yes.svg';
            })
            .fail(function(request, status, error){
                console.log("code: " + request.status)
                console.log("message: " + request.responseText)
                console.log("error: " + error);
            });
    }
    if(like_src == './like_yes.svg') {
        $.post('./like_ok.php', {like_clicker : liker, writer : post_writer, liked_post : like_post, check_like : 'cancel_like'})
            .done(function(){
                if(document.getElementById(like_id).innerText != '99+') {
                    document.getElementById(like_id).innerText = Number(document.getElementById(like_id).innerText) - 1;
                }
                e.src = './like_no.svg';
            })
            .fail(function(request, status, error){
                console.log("code: " + request.status)
                console.log("message: " + request.responseText)
                console.log("error: " + error);
            });
    }
    
}

function follow(e) {
    var followed_user = e.getAttribute('class').split(' ')[2];
    var follower = e.getAttribute('class').split(' ')[1];
    var follow_src = e.getAttribute('src');
    if(follow_src == './follow_no.svg') {
        $.post('./follow_ok.php', {follow_clicker : follower, followedUser : followed_user, check_follow : 'be_follow'})
            .done(function(){
                // document.getElementsByClassName(followed_user)[all].src = './follow_yes.svg';
                e.src = './follow_yes.svg';
            })
            .fail(function(request, status, error){
                console.log("code: " + request.status)
                console.log("message: " + request.responseText)
                console.log("error: " + error);
            });
    }
    if(follow_src == './follow_yes.svg') {
        $.post('./follow_ok.php', {follow_clicker : follower, followedUser : followed_user, check_follow : 'cancel_follow'})
            .done(function(){
                // document.getElementsByClassName(followed_user)[all].src = './follow_no.svg';
                e.src = './follow_no.svg';
            })
            .fail(function(request, status, error){
                console.log("code: " + request.status)
                console.log("message: " + request.responseText)
                console.log("error: " + error);
            });
    }
    
}
var is_open_noti = false;
function notice_window(e) {
    if(is_open_noti == false) {
        var recipient = e.getAttribute('alt')
        $.post('./read_ok.php', {read : 'yes' , recipter : recipient})
            .done(function(){
                // document.getElementsByClassName(followed_user)[all].src = './follow_no.svg';
                document.getElementById('notice_box').style.display = 'flex';
                document.getElementById('noti').src = './notice_no.svg';
                is_open_noti = true;
            })
            .fail(function(request, status, error){
                console.log("code: " + request.status)
                console.log("message: " + request.responseText)
                console.log("error: " + error);
            });
    }else{
        document.getElementById('notice_box').style.display = 'none';
        document.getElementById('noti').src = './notice_no.svg';
        is_open_noti = false;
    }
    
}
function del_noti(e) {
    var noti_reader =  e.getAttribute('alt');
    var noti_id = e.getAttribute('id');
    $.post('./del_alert_ok.php', {recipter : noti_reader, notice : noti_id})
            .done(function(){
                // document.getElementsByClassName(followed_user)[all].src = './follow_no.svg';
                e.parentElement.remove();
            })
            .fail(function(request, status, error){
                console.log("code: " + request.status)
                console.log("message: " + request.responseText)
                console.log("error: " + error);
            });
}
var is_open_comment = false;
function comment_window(e) {
    if(is_open_comment == false) {
        var id_name = e.getAttribute('alt');
        document.getElementById(id_name).style.display = 'flex';
        is_open_comment = true;
    }else{
        var id_name = e.getAttribute('alt');
        document.getElementById(id_name).style.display = 'none';
        is_open_comment = false;
    }
}

function post_comment(e) {
    var id_name = e.getAttribute('alt');
    var comm_writer = e.getAttribute('class').split(' ')[2];
    var commented_post_id = e.getAttribute('alt').split('_')[0];
    var comm_cont = document.getElementById(id_name).value;
    if(comm_cont == "") {
        alert('댓글 내용을 입력해주세요.');
        return;
    }else{
        if(!confirm('댓글을 게시한 후에는 수정이 불가능 합니다.')) {
            return;
        }
    }
    // console.log(comm_writer + ' / ' + commented_post_id + ' / ' + comm_cont);
    var today = new Date();
    var year = today.getFullYear();
    var month = ('0' + (today.getMonth() + 1)).slice(-2);
    var day = ('0' + today.getDate()).slice(-2);
    var dateString = year + '-' + month  + '-' + day;
    var hours = ('0' + today.getHours()).slice(-2); 
    var minutes = ('0' + today.getMinutes()).slice(-2);
    var seconds = ('0' + today.getSeconds()).slice(-2); 
    var timeString = hours + ':' + minutes  + ':' + seconds;
    var now = dateString+' '+timeString;
    console.log(now);
    $.post('./post_comment.php', {commented_post : commented_post_id , main_cont : comm_cont , writer : comm_writer , current_time : now})
            .done(function(){
                alert('댓글이 등록되었습니다.');
                document.getElementById(id_name).value = "";
                var parentBox = document.getElementById(comm_writer+commented_post_id);
                var comm_box = document.createElement('div');
                comm_box.setAttribute('class','comment');
                var interaction_box = document.createElement('div');
                interaction_box.setAttribute('class','comment_interaction');
                var user = document.createElement('p');
                var main = document.createElement('p');
                var date = document.createElement('p');
                var tmp_tag_list = [user,main,date];
                var tmp_value_list = [comm_writer,comm_cont,now];
                for(var i = 0; i < 3; i++) {
                    tmp_tag_list[i].innerText = tmp_value_list[i];
                    comm_box.appendChild(tmp_tag_list[i]);
                }   
                
                parentBox.insertBefore(comm_box, parentBox.firstChild);
                if(document.getElementById(commented_post_id+'comment_cnt').innerText != '99+') {
                    document.getElementById(commented_post_id+'comment_cnt').innerText = Number(document.getElementById(commented_post_id+'comment_cnt').innerText) + 1;
                }
                
            })
            .fail(function(request, status, error){
                console.log("code: " + request.status)
                console.log("message: " + request.responseText)
                console.log("error: " + error);
                alert('오류');

            });
}

function like_comm(e) {
    var like_comment = e.getAttribute('id');
    var liker = e.getAttribute('alt');
    var comm_like_src = e.getAttribute('src');
    var comment_writer = e.getAttribute('class');
    var comm_like_id = like_comment + 'like';
    if(comm_like_src == './like_no.svg') {
        $.post('./comm_like_ok.php', {like_clicker : liker, writer : comment_writer, liked_comm : like_comment, check_like : 'be_like'})
            .done(function(){
                if(document.getElementById(comm_like_id).innerText != '99+') {
                    document.getElementById(comm_like_id).innerText = Number(document.getElementById(comm_like_id).innerText) + 1;
                }
                e.src = './like_yes.svg';
            })
            .fail(function(request, status, error){
                console.log("code: " + request.status)
                console.log("message: " + request.responseText)
                console.log("error: " + error);
            });
    }
    if(comm_like_src == './like_yes.svg') {
        $.post('./comm_like_ok.php', {like_clicker : liker, writer : comment_writer, liked_comm : like_comment, check_like : 'cancel_like'})
            .done(function(){
                if(document.getElementById(comm_like_id).innerText != '99+') {
                    document.getElementById(comm_like_id).innerText = Number(document.getElementById(comm_like_id).innerText) - 1;
                }
                e.src = './like_no.svg';
            })
            .fail(function(request, status, error){
                console.log("code: " + request.status)
                console.log("message: " + request.responseText)
                console.log("error: " + error);
            });
    }
    
}

function chatgpt() {
    var  mychat = document.getElementById('search_box').value;
    $.post('./api.php', {ques : mychat})
        .done(function(){
            fetch('./api.php')
                .then(response => response.text())
                .then(data => {
                    var chat = document.getElementById('chat_box')
                    var myQ = document.createElement('div');
                    var inner_myQ = document.createElement('p');
                    myQ.setAttribute('class','myQ');
                    inner_myQ.innerText = data;
                    myQ.appendChild('inner_myQ');
                    chat.appendChild('myQ');
                    // document.getElementById('result').innerText = data;
                });
            
        })
        .fail(function(request, status, error){
            console.log("code: " + request.status)
            console.log("message: " + request.responseText)
            console.log("error: " + error);
        });
}


var divs = document.getElementsByClassName('snowflake');
for (var i = 0; i < divs.length; i++) {
    var random = Math.floor(Math.random() * 80);
    var random2 = Math.floor(Math.random() * 10); 

    divs[i].style.right = `${random}%`;
    divs[i].style.animationDuration = `${5 + (random2 / 10)}s`;
    divs[i].style.animationDelay = `-${random}s`;
}