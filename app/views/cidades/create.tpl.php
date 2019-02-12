<?
$controller = core\Uri::retController(); 
//echo "<pre>"; print_r($uri); echo "</pre>";
?>
<section class="wrapper-content <?=strtolower($controller)?>">
	<div class="main">
		<div class="container">
			<div class="row">
			
				<div class="col">
				
					<div class="alert title alert-primary" role="alert">
						<h1 class="text-center">
						<?=(empty($_GET['id']))?'Cadastrar Novo Cidade':'Editar Cidade';?>
						</h1>
					</div>
					
					<form id="ruleCreate" action="/cidades/create" accept-charset="utf-8" method="POST">

						<div class="form-group">

							<label for="cidade">Cidade</label>

							<input type="hidden" name="Cidade[id]" 
								class="form-control" pattern="[\d]{5,20}" 
								value="<?=(!empty($_GET['id'])?$_GET['id']:NULL)?>">

							<input type="text" name="Cidade[cidade]" 
								class="form-control" id="cidade" placeholder="Nome de Cidade" 
								maxlength="100" required="required" pattern="[\w\s]+"
								value="<?=(!empty($data['cidade'])?$data['cidade']:NULL)?>">

						</div>

						<div class="form-group">

							<label for="slug">Slug</label>

							<input type="text" name="Cidade[slug]" 
								class="form-control" id="slug" 
								placeholder="Uma slug Segura" minlength="8" maxlength="255" 
								required="required" pattern="[\w\s\-]+"
								value="<?=(!empty($data['slug'])?$data['slug']:NULL)?>">

						</div>

						<div class="form-group">

							<label for="tempo-id">Tempo ID</label>

							<input type="tempo-id" name="Cidade[tempo_id]" 
								class="form-control" id="tempo-id" 
								placeholder="ID do tempo desta Cidade" maxlength="145"  
								value="<?=(!empty($data['tempo_id'])?$data['tempo_id']:NULL)?>">
						</div>
						
						<a class="btn btn-success" href="/<?=strtolower($controller)?>/index"> Voltar </a>
						<button type="submit" class="btn btn-primary" user="action" value="create">Salvar</button>

					</form>
				</div>

			</div>
		</div>
	</div>
</section>