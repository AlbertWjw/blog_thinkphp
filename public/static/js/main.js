$(function(){
	'use strict';
	
	var user = $("#user");
	var paw = $("#paw");
	var email = $("#email");
	var form = $("#loginform");

	user.on('blur',function(){
		if(user.val().length>16 || user.val().length<2){
			$('#uhint').css("display","block");
		}
		else{
			var reg = new RegExp("^[a-zA-Z0-9]*$");
			if(!reg.test(user.val())){
				$('#uhint').css("display","block");
			}
			else{
				$('#uhint').css("display","none");
			}
		}
	})
	paw.on('blur',function(){
		if(paw.val().length>16 || paw.val().length<2){
			$('#zhint').css("display","block");
		}
		else{
			var reg = new RegExp("^[a-zA-Z0-9]+$");
			if(!reg.test(paw.val())){
				$('#zhint').text('密码格式错误');
				$('#zhint').css("display","block");
			}
			else{
				$('#zhint').css("display","none");
			}
		}
	})
	email.on('blur',function(){
		if(email.val().length>320 || email.val().length<3){
			$('#ehint').css("display","block");
		}
		else{
			var reg = new RegExp("^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$");
			if(!reg.test(email.val())){
				$('#ehint').css("display","block");
			}
			else{
				$('#ehint').css("display","none");
			}
		}
	})

	form.on('submit',function(e){
		e.preventDefault();
		user.trigger('blur');
		paw.trigger('blur');
		if($('#uhint').css("display") !=="block" || $('#zhint').css("display") !=="block" || $('#ehint').css("display") != "block"){
			/*ajax*/
			$.ajax("ajaxin", {
				method:'post',
				data:{
					username:user.val(),
					password:paw.val(),
				},
				success:function(data){
					if(data == "账号密码不能为空"){
						user.trigger('blur');
						paw.trigger('blur');
					}else if(data =="登录失败"){
						$('#zhint').text('用户名或密码错误');
						$('#zhint').css("display","block");
					}else if(data.indexOf("登录成功")!=-1){
						window.location.href = 'index';
					}
				},
				error:function(){
					alert('网络错误或文件不存在');
				}
			});
		}
	})
})