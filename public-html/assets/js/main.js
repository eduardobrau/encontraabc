$(document).ready(function(){

	$("button.btn-danger.delete").on('click', function(){
		
		const id = $(this).attr('data-id');
		const title = $(this).attr('data-title');
		console.log(id);

		$('div.modal-footer .btn-danger').remove();
		
		$('h4#modal-title'). 
		html('Gostaria de deletar esse dado?')
		.attr({
			'style':'',
			'font-size':''
		});

		const htmlElements = `
			<p id="modalShowTitle">
				<span style="font-weight:700">TÍTULO:</span> ${title}
			</p>
			<p id="modalShowId">
				<span style="font-weight:700">ID:</span> ${id}
			</p>
			<div class="alert alert-danger" role="alert">
				Uma vez deletado essa operação é inreversivel!
			</div>
		`;

		$('div.modal-body').html(htmlElements);

		$('<button></button>', 
			{
				id: 'modalDeleteData',
				class: 'btn btn-danger',
				attr:		'data-id'
			})
		.html('Deletar')
		.insertAfter('div.modal-footer .btn-default');

		$("button#modalDeleteData")
		.attr("data-id",id);
		$("#modalEncontraAbc").modal('show');
		
	});	

	$('button#loginModal').on('click', function(){
		$('div.modal-body').html('');
		$('div.modal-footer').html('');
		const formLogin = `<div class="site-login">
    
    	<div class="account-wall">
				<div id="logo">
					<img class="profile-img" src="../../assets/img/logo-encontra-abc.svg" alt="" style="width:273px; height:73px;">
				</div>
				<form id="loginForm" action="/site/login" method="post">
					
					<div class="form-group row field-loginform-email required">
						<label class="col-lg-2 control-label" for="loginform-email">Email</label>
						<div class="col-lg-10">
							<input type="text" id="loginform-email" class="form-control" name="LoginForm[email]" aria-required="true" aria-invalid="false">
						</div>
					</div>
					
					<div class="form-group row field-loginform-password required">
						<label class="col-lg-2 control-label" for="loginform-password">Senha</label>
						<div class="col-lg-10">
							<input type="password" id="loginform-password" class="form-control" name="LoginForm[password]" aria-required="true" aria-invalid="false">
						</div>
					</div>
					
					<div id="loginError" class="alert alert-danger"><strong>Erro!</strong></div>
					
					<div id="btnEntrar" class="form-group row">
						<button id="confirmEntry" type="submit" class="btn btn-primary">Entrar</button>
					</div>

					<div class="form-group row field-loginform-rememberme">
						<div class="col-lg-offset-0 col-lg-9">
							<input type="hidden" name="LoginForm[rememberMe]" value="0">
							<input type="checkbox" id="loginform-rememberme" name="LoginForm[rememberMe]" value="1" checked=""> 
							<label for="loginform-rememberme">Lembrar-me</label>
						</div>
						<div class="col-lg-12"><p class="help-block help-block-error "></p></div>
					</div>

        </form>
        
        <hr class="ten">

        <div class="login-info">
          <p class="text-center">Ou você pode fazer o login via Facebook.</p>
        </div>
        
        <div class="login-facebook">
					<button type="button" id="loginFacebook" class="btn btn-facebook">
						<span class="fa fa-facebook-square" aria-hidden="true"></span>
						Entrar com Facebook
					</button>
          <a class="btn btn-secondary" href="/usuarios/create">Criar uma conta</a>
        </div>

			</div>
			</div>`; 
			$('h4#modal-title')
			.addClass('text-center')
			.attr({
				'style':'font-size:30px',
				'text-align': 'center'
			})
			.html('Entrar');
			$('div.modal-body').html(formLogin);
			$("#modalEncontraAbc").modal('show');
	});

	$('#btnResponse').on('click', function(){

		var enqueteResponse = $("input[name='AppEnquete[value]']:checked").val();
		
		if(statusConexao === 'connected'){
			//var uid = response.authResponse.userID;
	  	//accessToken = response.authResponse.accessToken;
	  	FB.api("me/?fields=id,name,email", function(info) {
		    console.log(info);
		    
		    $.ajax({

					url: "user/create.php",
					dataType: 'json',
					type: 'GET',
					data:{
						'id' : info.id,
						'name' : info.name,
						'email' : info.email,
						'enqueteResponse' : enqueteResponse
					},
					success:function(data){
					// Store
					if(!localStorage.appEdusitesBRuserAdd){
						localStorage.appEdusitesBRuserAdd = data.appEdusitesBRuserAdd;
					} 
					// Retrieve
					//console.log(localStorage.appEdusitesBRuserAdd);
					//The syntax for removing the "appEdusitesBRuserAdd" localStorage item is as follows:
					//localStorage.removeItem("appEdusitesBRuserAdd");
					}

				});//End ajax

		  });
			$('#logon').hide();
    	$('#bemvindo').show();

		}else if (statusConexao === 'not_authorized') {
			//O usuário está logado no Facebook, mas não no app.
	    console.log("Você está logado no Facebook, mas não no App.");
	    $('#logon').show();
    	$('#bemVindo').hide();
		}else{
			logar();
		}

	});


});

$(document).on('click', 'button#modalDeleteData',function(){
	
	datas = {
		url: '/usuarios/delete',
		id: $(this).attr('data-id'),
	}

	const {url,id} = datas;

	$.ajax({
		url: url,
		dataType: 'json',
		type: "POST",
		data: { id },
		success: function(data) {

			$("#modalEncontraAbc h4#modal-title")
			.html(data.title);
			
			$('div.modal-body')
			.html($('<div>',{
				class:	''+data.class+'',
				role:		'alert'
			})
			.text(data.msg));
			
			$("#modalEncontraAbc").modal();
			
			setTimeout( () => {
				location.reload();
			},2000);	
		}
	});

});