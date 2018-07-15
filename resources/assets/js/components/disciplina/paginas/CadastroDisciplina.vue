<template>             
	<div> 
		<crudHeader texto="Adicionar Disciplina">
			<li class="breadcrumb-item">
				<router-link to="/" exact><a>Disciplina </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Criação</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">   
				<Formulario :url="url" :form="form" metodo="post">
					<crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
						<label for="nome">Nome:</label>
						<input type="text" id="nome" name="nome" class="form-control" v-model="form.nome" v-bind:class="{ 'is-invalid': form.errors.has('nome') }"> 
					</crudFormElemento> 
					<crudFormElemento :errors="form.errors.has('descricao')" :errors_texto="form.errors.get('descricao')">
						<label for="descricao">Descricao:</label>
						<input type="text" id="descricao" name="descricao" class="form-control" v-model="form.descricao" v-bind:class="{ 'is-invalid': form.errors.has('descricao') }">
					</crudFormElemento> 
				</Formulario> 
			</div> 
		</div>   
	</div>
</template>


<script> 
	import Form from '../../core/Form'; 
	export default {

		props:[
		'url' 
		], 

		data() {
			return {                
				form: new Form({
					nome: '',    
					descricao: ''               
				})
			}
		}, 

	} 

</script>
