/**
 * Created by pc on 2017/11/16.
 */
function show1()  //显示隐藏层和弹出层
{
    var hideobj=document.getElementById("hidebg1");
    hidebg1.style.display="block";  //显示隐藏层
    hidebg1.style.height=document.body.clientHeight+"px";  //设置隐藏层的高度为当前页面高度
    document.getElementById("login1").style.display="block";  //显示弹出层
}
function hide1()  //去除隐藏层和弹出层
{
    document.getElementById("hidebg1").style.display="none";
    document.getElementById("login1").style.display="none";
}
var vue = new Vue({
   el:'#container',
    data: {
        note: '',
        notebook: "",
        username: '',
        content: '',
        details:[]
    },

    methods:{

        setCookie:function (cname,cvalue,exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        },

        getCookieValue:function (cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
            }
            return "";
        },
        deleteCookie:function (cname) {
            this.setCookie("username","",-1);
            window.location.href="../login.html";
        },
        logout:function () {
            this.deleteCookie("username");
        },
        saveCreate:function () {

            if(this.note==""){
                alert("请输入文件名！")
                hide1();
            }else if(this.notebook == ""){
                alert("请选择目标笔记本！");
                hide1();
            }else{
                this.$http.get("http://localhost/CNote/php/NewNote.php",{
                    params:{
                        act:'getNoteNames',
                        username:this.username,
                        notebook:this.notebook,
                    }
                }).then(function (response) {
                    this.existNotes=response.data;
                    var duplicate=false;
                    for(var i=0;i<this.existNotes.length;i++){
                        if(this.existNotes[i].noteName == this.noteName){
                            duplicate=true;
                        }
                    }
                    if(duplicate==true) {
                        alert("该笔记已经存在，请重新命名！");
                        hide1();
                    }else{
                        var date = new Date();
                        var month = date.getMonth()+1;
                        var day = date.getDate();
                        var hour = date.getHours();
                        var minute = date.getMinutes();
                        var second = date.getSeconds();
                        if(hour.toString().length<2){
                            hour = '0'+hour;
                        }
                        if(minute.toString().length<2){
                            minute = '0'+minute;
                        }

                        if(second.toString().length<2){
                            second = '0'+second;
                        }
                        if(month.toString().length<2){
                            month = '0'+month;
                        }
                        if(day.toString().length<2){
                            day = '0'+day;
                        }
                        this.createTime = date.getFullYear() + '-' + month + '-'+ day + ' ' + hour +':'+minute+':'+second;
                        var content = CKEDITOR.instances.editor1.getData();
                        alert(content);
                        this.$http.get("http://localhost/CNote/php/NoteDetail.php",{
                            params:{
                                act:'saveNote',
                                username:this.username,
                                note:this.note,
                                notebook:this.notebook,
                                content:content,
                                createTime:this.createTime
                            }
                        }).then(function (response) {
                            if(response.data.errorCode == 0){
                                alert("保存成功！");
                                hide1();
                            }
                        }).catch(function (error) {
                            alert("出现了未知的错误!")
                        })
                    }
                }).catch(function (error) {
                    alert("出现了未知的错误!")
                });




            }


        }
    },
    mounted(){
        var thisUrl = document.URL;
        var getVal = thisUrl.split('?')[1];
        var note =  decodeURI(getVal.split('=')[1]);
        var notebook = decodeURI(getVal.split('=')[2]);
        this.note = note;
        this.notebook = notebook;
        this.username=this.getCookieValue("username");
        this.$http.get("http://localhost/CNote/php/NoteDetail.php",{
            params:{
                act:'getNoteDetail',
                username:this.username,
                note:note,
                notebook:notebook
            }
        }).then(function (response) {
            this.content = response.data;
        }).catch(function (error) {
            alert("发生了未知的错误！");
        })
    }
});