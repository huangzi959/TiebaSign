function logout(){
  $.ajax({
            type:"GET",
            url:"/index.php/User/Operation/logout.html",
            complete:function(re){
               location.reload();
            }
  });
}

function login(from){
  $.ajax({
            type:"POST",
            url:"/index.php/User/Operation/login.html",
            data:{
                  user:$("#username").val(),
                  pass:$("#password").val(),
                  remember_me:$("#remember-me").val()
                  },
            success:function(re){
                var jsonObject = JSON.parse(re);
                if(jsonObject['info']=="Success"){
                  success_notify("登录成功，正在跳转");
                  if(from == 'NULL') window.location.href='/';
                  else window.location.href=from;
                }else{
                  console.log(re);
                  error_notify(jsonObject['error']);
                }
            }
  });
}

function register(from){
  $.ajax({
            type:"POST",
            url:"/index.php/User/Operation/register.html",
            data:{
                  username:$("#username").val(),
                  password:$("#password").val(),
                  email:$("#email").val(),
                  code:$("#code").val()
                  },
            success:function(re){
                console.log(re);
              var jsonObject = JSON.parse(re);
                if(jsonObject['info']=="Success"){
                  success_notify("注册成功，自动登录完毕，正在跳转");
                  if(from == 'NULL') window.location.href='/';
                  else window.location.href=from;
                }else{
                  console.log(re);
                  error_notify(jsonObject['error']);
            }
          }
  });
}

