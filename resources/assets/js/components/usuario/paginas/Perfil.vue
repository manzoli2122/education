<template>             
	 <div>  
		<crudHeader :texto="'Perfis do ' + usuario.name ">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Usuário </a></router-link> 
			</li>
			<li class="breadcrumb-item active">{{usuario.name}}</li>
			<li class="breadcrumb-item"> Perfis </li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">  

				<perfilDatatable :perfis="perfis"  v-on:perfilRemovido="buscarPerfilParaAdicionar($event)" :url="url"> </perfilDatatable>  
 
				<formAdicionarPerfil  v-on:perfilAdicionado="perfilAdicionado($event)" :perfis="perfis" :url="url"> </formAdicionarPerfil>   
 
			</div> 
		</div>  
	</div>
</template>


<script>
  
Vue.component('formAdicionarPerfil', require('./_PerfilFormAdicionar.vue')); 
Vue.component('perfilDatatable', require('./_perfilDatatable.vue'));

export default {
 
	props:[ 
	'url' 
	],  

	data() {
		return {    
			usuario:'',
			perfis:'',  
		}
	},
 
 	created() { 
		axios.get(this.url + '/' + this.$route.params.id)
			.then(response => {
				this.usuario = response.data;
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Usuário', error.response.data);
				alertProcessandoHide();
			}); 
		//this.buscarPerfilParaAdicionar();
		axios.get(this.url + "/" + this.$route.params.id + "/perfil/cadastrar")
	 				.then(response => {
	 					this.perfis = response.data;
	 				})
	 				.catch(error => {
	 					toastErro("Não foi possivel achar a Perfil", error.response.data);
					 });  
	 }, 





	 methods: {


	 		buscarPerfilParaAdicionar(event) {
				 this.perfis = event;

/*
	 			axios.get(this.url + "/" + this.$route.params.id + "/perfil/cadastrar")
	 				.then(response => {
	 					this.perfis = response.data;
	 				})
	 				.catch(error => {
	 					toastErro("Não foi possivel achar a Perfil", error.response.data);
					 });  
					 */
			 },
			 


			perfilAdicionado(event) {
				this.perfis = event;
	 		},


 
	},
	   
 }
 
 </script>
 
 <style scoped> 
 </style>