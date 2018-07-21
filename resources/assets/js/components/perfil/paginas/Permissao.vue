<template>             
	<div> 
		<crudHeader :texto="'Permissões do perfil ' + perfil.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perfis </a></router-link> 
			</li> 
            <li class="breadcrumb-item active">Permissões</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 

				<permissaoDatatable :permissoes="permissoes"  v-on:permissaoRemovida="permissaoRemovida($event)" :url="url"> </permissaoDatatable> 
				
				<formAdicionarPermissao v-if="permissoes.length > 0" v-on:permissaoAdicionada="permissaoAdicionada($event)" :permissoes="permissoes" :url="url"> </formAdicionarPermissao>   

				
				<permissaoDatatableLog  :permissoes="permissoes" v-on:permissaoRemovida="permissaoRemovida($event)" :url="url"> </permissaoDatatableLog>  
			</div> 
		</div>   
	</div>
</template>


<script>
 
Vue.component('permissaoDatatable', require('./_PermissaoDatatable.vue'));
Vue.component('permissaoDatatableLog', require('./_PermissaoDatatableLog.vue')); 
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