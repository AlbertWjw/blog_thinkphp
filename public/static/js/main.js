$(function(){
	'use strict';
	
	var user = $("#user");
	var paw = $("#paw");
	var paw2 = $("#paw2");
	var email = $("#email");
	var form = $("#loginform");

	user.on('blur',function(){
		if(user.val().length>16 || user.val().length<2){
			$('#uhint').css("display","block");
		}
		else{
			var reg = new RegExp("^[a-zA-Z0-9]*$");
			if(!reg.test(user.val())){
				$('#zhint').text('用户名格式错误');
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
	paw2.on('blur',function(){
		if(paw.val()!='' &&paw.val()!= paw2.val()){
			$('#thint').css("display","block");
		}
		else{
			$('#thint').css("display","none");
		}
	})
	email.on('blur',function(){
		if(email.val().length>320 || email.val().length<3){
			$('#ehint').css("display","block");
		}
		else{
			var reg = new RegExp("^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$");
			if(!reg.test(email.val())){
				$('#ehint').text('注册失败，请重试');
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
		paw2.trigger('blur');
		email.trigger('blur');
		//输入信息验证，如果没问题进行 登陆/注册 操作
		if(email.length<=0){ //登陆
			if($('#uhint').css("display") !=="block" || $('#zhint').css("display") !=="block"){
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
		}else{//注册
			if($('#uhint').css("display") !=="block" || $('#zhint').css("display") !=="block" ||
			 $('#thint').css("display") !=="block" || $('#ehint').css("display") != "block"){
				$.ajax("ajaxup", {
					method:'post',
					data:{
						username:user.val(),
						password:paw.val(),
						email:email.val(),
					},
					success:function(data){
						if(data == "账号密码不能为空"){
							user.trigger('blur');
							paw.trigger('blur');
							email.trigger('blur');
						}else if(data == "用户名已存在"){
							$('#uhint').text("用户名已存在");
							$('#uhint').css("display","block");
						}else if(data =="注册失败"){
							$('#ehint').text('注册失败请重试');
							$('#ehint').css("display","block");
						}else if(data.indexOf("注册成功")!=-1){
							window.location.href = 'index';
						}
					},
					error:function(){
						alert('网络错误或文件不存在');
					}
				});
			}
		}
	})
})