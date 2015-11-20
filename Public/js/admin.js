$(function() {
  $('#btn-add-find').on('click', function() {
    $('#find-add-prompt').modal({
      relatedTarget: this,
      onConfirm: function(e) {
          $.ajax({
		        type:"POST",
		        url:"/index.php/Home/Setting/AddCookie",
		        data:{
		              cookie:$("#cookie-input").val()
		              },
		        success:function(re){
              console.log(re);
               if(notify_re(re)) location.reload();
		        }
          });
      }
    });
  });
});

function DeleteFindBtnClick(delete_id)
{
  $.ajax({
  type:"POST",
  url:"/index.php/Home/Setting/DelCookie",
  data:{
        id:delete_id
        },
  success:function(re){
        if(notify_re(re))
        {
        	$('#cookie-list-tr-'+delete_id).fadeOut(800);
        }
  }
  });
}

function OpenCookieValue(id){
  $('#cookievalue').text($('#cookie-list-val-'+id).val());
  $('#cookievalue-model').modal('open');
}

function ReloadBtnClick(op_id)
{
  $.ajax({
  type:"POST",
  url:"/index.php/Home/Setting/CookieReload",
  data:{
        cookieid:op_id
        },
  success:function(re){
        notify_re(re);
  }
  });
}
