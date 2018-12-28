<?php 
$controller = core\Uri::retController(); 
//echo "<pre>"; print_r($uri); echo "</pre>";
?>
<section class="wrapper-content">
	<div class="main">
		<div class="container">
			<div class="row">
			
				<div class="col">
				
					<div class="alert title alert-primary" role="alert">
						<h1 class="text-center">
						<?=(empty($_GET['id']))?'Cadastrar Novo Usuário' :'Editar Usuário';?>
						</h1>
					</div>
					
					<form id="ruleCreate" action="/<?=strtolower($controller)?>/create" accept-charset="utf-8" method="POST">

						<div class="form-group">

							<label for="usuario">Usuário</label>

							<input type="hidden" name="USUARIO[id]" 
								class="form-control" pattern="[\d]{5,20}" 
								value="<?=(!empty($_GET['id'])?$_GET['id']:NULL)?>">

							<input type="text" name="USUARIO[usuario]" 
								class="form-control" id="usuario" placeholder="Nome de Usuário" 
								maxlength="100" required="required" pattern="[\w]+"
								value="<?=(!empty($data[0]['usuario'])?$data[0]['usuario']:NULL)?>">

						</div>

						<div class="form-group">

							<label for="senha">Senha</label>

							<input type="password" name="USUARIO[senha]" 
								class="form-control" id="senha" 
								placeholder="Uma Senha Segura" minlength="8" maxlength="255" 
								required="required" pattern="[\w\s]+">

						</div>

						<div class="form-group">

							<label for="email">Email</label>

							<input type="email" name="USUARIO[email]" 
								class="form-control" id="email" 
								placeholder="Seu email" maxlength="145" 
								required="required" 
								value="<?=(!empty($data[0]['email'])?$data[0]['email']:NULL)?>">
						</div>
						
						<a class="btn btn-success" href="/usuarios/index"> Voltar </a>
						<button type="submit" class="btn btn-primary" user="action" value="create">Salvar</button>

					</form>
				</div>

			</div>
		</div>
	</div>
</section>