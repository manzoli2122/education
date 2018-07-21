<template>             
	<div>
		<crudHeader :texto="'Alterar Perfil ' + model.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perfis </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="url +'/' + $route.params.id" :form="form" metodo="patch"> 
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

	import Form from '../../../core/Form';

	export default {

		props:[
		'url' 
		], 

		data() {
			return {                
				model:'',
				form: new Form({ 
					descricao: ''               
				})
			}
		},

		watch: { 
			model: function (newmodel, oldmodel) {
				this.form.nome = this.model.nome;
				this.form.descricao = this.model.descricao;  
			}

		},    

		created() {
			alertProcessando();
			axios.get(this.url + '/' + this.$route.params.id )
			.then(response => {
				this.model = response.data ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar a Perfil', error.response.data);
				alertProcessandoHide();
			});
		},

	}



</script>
