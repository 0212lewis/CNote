/**
 * Created by pc on 2017/11/13.
 */
function show1()  //显示隐藏层和弹出层
{
    var hideobj=document.getElementById("hidebgSaveInfo");
    hidebgSaveInfo.style.display="block";  //显示隐藏层
    hidebgSaveInfo.style.height=document.body.clientHeight+"px";  //设置隐藏层的高度为当前页面高度
    document.getElementById("loginSaveInfo").style.display="block";  //显示弹出层
}
function hide1()  //去除隐藏层和弹出层
{
    document.getElementById("hidebgSaveInfo").style.display="none";
    document.getElementById("loginSaveInfo").style.display="none";
}

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


var vue = new Vue({
    el:'#container',
    data:{
        username:'',
        items:[{
                username:'',
                sex:'',
                phone:'',
                email:'',
                address:'',
                unit:''
            }]
    },
    methods:{

        getCookieValue:function (cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);//去掉cookie开头的空格
                if (c.indexOf(name) != -1) return c.substring(name.length, c.length);//直接返回的就是cookie的键对应的值
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

        //保存修改的用户信息
        saveInfo:function () {

            if((this.items[0].sex == "")||(this.items[0].phone=="")||(this.items[0].email=="")||(this.items[0].address=="")||(this.items[0].unit=="")){
                alert("您输入的信息不完整！");
            }else{
                this.$http.get("http://localhost/CNote/php/Account.php",{
                    params:{
                        act:"saveInfo",
                        username:this.username,
                        sex:this.items[0].sex,
                        phone:this.items[0].phone,
                        email:this.items[0].email,
                        address:this.items[0].address,
                        unit:this.items[0].unit
                    }
                }).then(function (response) {
                    if(response.data.errorCode == 0){
                        hide1();
                        alert("修改成功！");
                        window.location.reload();
                    }
                }).catch(function (error) {
                    alert("发生了未知的错误！");
                })
            }
            }

    },
    mounted(){

        // alert(this.getCookieValue("username"));
        this.username=this.getCookieValue("username");
        this.$http.get('http://localhost/CNote/php/Account.php',{
            params:{
                act:"getAccountInfo",
                username:this.username
            }
        }).then(function (response) {
            this.items=response.data;
        }).catch(function (error) {
            alert("出现了未知的错误！")
        })
    }

});