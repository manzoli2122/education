<template>             
	<div> 
		<crudHeader :texto="perfil.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perfil </a></router-link> 
			</li>
            <li class="breadcrumb-item">
				<router-link   :to="'/show/'+ $route.params.id" exact><a>{{perfil.nome}} </a></router-link> 
			</li> 
            <li class="breadcrumb-item active">Permissões</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 

				 <permissaoDatatable :permissoes="permissoes"  v-on:permissaoRemovida="permissaoRemovida($event)" :url="url"> </permissaoDatatable> 
				
					<formAdicionarPermissao  v-on:permissaoAdicionada="permissaoAdicionada($event)" :permissoes="permissoes" :url="url"> </formAdicionarPermissao>   
			</div> 
		</div>   
	</div>
</template>


<script>
 
Vue.component('permissaoDatatable', require('./_PermissaoDatatable.vue'));

Vue.component('formAdicionarPermissao', require('./_PermissaoFormAdicionar.vue'));

export default {

	props:[
	'url' 
	], 

	data() {
		return {        
            perfil:'', 
            permissoes:'',
		}
	},

	 



    created() {
 		 
 		axios.get(this.url + '/' + this.$route.params.id )
 		.then(response => {
 			this.perfil = response.data ;
 		})
 		.catch(error => {
 			//console.log(error.response);
 			toastErro('Não foi possivel achar a Perfil' , error.response.data);
 			 
         });  

        axios.get(this.url + '/' + this.$route.params.id +'/permissao/adicionar')
 		.then(response => {
 			this.permissoes = response.data ;
 		})
 		.catch(error => {
 			toastErro('Não foi possivel achar a Permissoes' , error.response.data);
         });  
	 }, 
	 



	 methods: {


	 		permissaoRemovida(event) {
				this.permissoes = event; 
			 },
			  
			permissaoAdicionada(event) {
				this.permissoes = event;
	 		},


 
	},

 }
 
 </script>
 
 <style scoped>
 
 </style>