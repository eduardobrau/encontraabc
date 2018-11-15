$(document).ready(function(){

	$(".btn-danger.delete").on('click', function(){
		var id = $(this).attr('data-id');
		var title = $(this).attr('data-title');
		console.log(id);

		$('div.modal-body p, div.modal-footer .btn-danger').remove();

		$('<p>', {
			id: 'modalShowTitle',
			class: 'minhaClasse',
		})
		.html('<span style="font-weight:700">TÍTULO</span>: ' + title)
		.appendTo('div.modal-body');

		$('<p>', {
			id: 'modalShowId',
			class: 'minhaClasse',
		})
		.html('<span style="font-weight:700">ID:</span> ' + id)
		.appendTo('div.modal-body');

		$('<p>', {
			class: 'text-danger',
		})
		.html('<div class="alert alert-danger" role="alert">Uma vez deletado essa operação é inreversivel!</div>')
		.appendTo('div.modal-body');

		$('<a></a>', 
			{
				id: 'modalDeleteData',
				class: 'btn btn-danger',
				href: '#'
			})
		.html('Deletar')
		.insertAfter('div.modal-footer .btn-default');

		$("a#modalDeleteData").attr("href","index.php?module=usuarios&action=delete&id="+id);
		$("#myModal").modal('show');
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