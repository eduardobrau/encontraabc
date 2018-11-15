<div class="container">
	<div class="row">

		<div class="col">
		
			<div class="alert alert-primary" role="alert">
				<h1 class="text-center"><?= ( !empty($_GET['id']) && $user ) ? 'Editar Usuário '.$user[0]['usuario'] : 'Cadastrar Novo Usuário'?></h1>
			</div>
			<?php 
			
			$user = ( isset($data) ) ? $data : NULL;

			/* if(isset($errors)){
				foreach ($errors as $array) {
					echo '<div class="alert alert-danger" role="alert">';
					foreach ($array as $erro) {
						echo $erro;
					}
					echo '</div>';
				}
			}else{
				unset($_POST['USUARIOS'],$_GET['id']);
				if($userUpdate[0]):
					header('Location: index.php');
				else:
					echo $userUpdate[1];
				endif;
			} */
			?>
		  <form id="ruleCreate" action="index.php?module=usuarios&action=edit" accept-charset="utf-8" method="POST">

			  <div class="form-group">
			    <label for="usuario">Usuário</label>
          <input type="hidden" name="USUARIOS[id]" class="form-control" id="id" value="<?= ($user[0]['id']) ?>">
			    <input type="text" name="USUARIOS[usuario]" class="form-control" id="usuario" placeholder="Nome de Usuário" maxlength="100" required="required" pattern="[\w]+" value="<?= ($user[0]['usuario']) ?>">
			  </div>
			  <div class="form-group">
			    <label for="senha">Senha</label>
			    <input type="password" name="USUARIOS[senha]" class="form-control" id="senha" placeholder="Uma Senha Segura" minlength="8" maxlength="255" required="required" pattern="[\w\s]+">
			  </div>
			  <div class="form-group">
			    <label for="email">Email</label>
			    <input type="email" name="USUARIOS[email]" class="form-control" id="email" placeholder="Seu email" maxlength="145" required="required" value="<?= ($user[0]['email']) ?>">
			  </div>
			  
			  <a class="btn btn-success" href="index.php?module=usuarios&action=index"> Voltar </a>
			  <button type="submit" class="btn btn-primary" user="action" value="create">Salvar</button>

			</form>
		</div>

	</div>
</div>