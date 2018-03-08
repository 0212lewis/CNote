/**
 * Created by pc on 2017/11/15.
 */


function logoutConfirmshow()  //显示隐藏层和弹出层
{
    var hideobj=document.getElementById("hidebglogoutConfirm");
    hidebglogoutConfirm.style.display="block";  //显示隐藏层
    hidebglogoutConfirm.style.height=document.body.clientHeight+"px";  //设置隐藏层的高度为当前页面高度
    document.getElementById("loginlogoutConfirm").style.display="block";  //显示弹出层
}
function logoutConfirmhide()  //去除隐藏层和弹出层
{
    document.getElementById("hidebglogoutConfirm").style.display="none";
    document.getElementById("loginlogoutConfirm").style.display="none";
}



function deleteRemindShow()  //显示隐藏层和弹出层
{
    var hideobj=document.getElementById("hidebgdeleteRemind");
    hidebgdeleteRemind.style.display="block";  //显示隐藏层
    hidebgdeleteRemind.style.height=document.body.clientHeight+"px";  //设置隐藏层的高度为当前页面高度
    document.getElementById("logindeleteRemind").style.display="block";  //显示弹出层
}
function deleteRemindHide()  //去除隐藏层和弹出层
{
    document.getElementById("hidebgdeleteRemind").style.display="none";
    document.getElementById("logindeleteRemind").style.display="none";
}




var vue = new Vue({
    el:'#container',
    data:{
        username:'',
        authority:1,
        deleteName:'',
        managers:[],
        users:[]
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

        deleteConfirm:function () {
            deleteRemindHide()
            this.$http.get("http://localhost/CNote/php/AuthorityManagement.php",{
              params:{
                  act:'deleteAccount',
                  deleteName:this.deleteName,
              }
            }).then(function (response) {
                if(response.data.errorCode == 0){
                    alert("删除成功！");
                    window.location.reload();
                }
            }).catch(function (error) {
                alert("删除失败！");
            })
        },
        deleteRemind:function (name) {
            deleteRemindShow();
            this.deleteName = name
        },
        
        


    },
    mounted(){

        this.username=this.getCookieValue("username");
        this.authority=this.getCookieValue("authority");

        if(this.authority!=0){
            alert("抱歉，您无权浏览该页面，如有需要请与管理员联系！");
        }
        else{

        }
        //得到所有管理员信息
        this.$http.get("http://localhost/CNote/php/AuthorityManagement.php",{
            params:{
                act:'getAllManagers'
            }
        }).then(function (response) {
            this.managers=response.data;
            setTimeout(function () {
                $('#example1').DataTable();
            },0);
        }).catch(function (error) {
            alert("发生了未知的错误！");
        });

        //得到所有用户信息
        this.$http.get("http://localhost/CNote/php/AuthorityManagement.php",{
            params:{
                act:'getAllUsers'
            }
        }).then(function (response) {
            this.users=response.data;
            setTimeout(function () {
                $('#example2').DataTable();
            },0);
        }).catch(function (error) {
            alert("发生了未知的错误！");
        });


    }

});