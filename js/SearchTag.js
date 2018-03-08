
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
    data:{
        username:'',
        authority:0,
        notes:'',
        notebooks:'',

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


    },
    mounted(){
        this.username=this.getCookieValue("username");
        this.$http.get("http://localhost/CNote/php/SearchTag.php",{
            params:{
                act:'getAllNotes',
                username:this.username,
            }
        }).then(function (response) {
            this.notes = response.data;
            setTimeout(function () {
                $('#example1').DataTable();
            },0);
        }).catch(function (error) {
            alert("发生了未知的错误!");
        });

        this.$http.get("http://localhost/CNote/php/SearchTag.php",{
            params:{
                act:'getAllNotebooks',
                username:this.username,
            }
        }).then(function (response) {
            this.notebooks = response.data;
            setTimeout(function () {
                $('#example2').DataTable();
            },0);
        }).catch(function (error) {
            alert("发生了未知的错误!");
        })

    }

});