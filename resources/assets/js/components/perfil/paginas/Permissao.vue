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

				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatablePerfisPermissao" :reload="permissoes" v-on:permissaoRemovida="permissaoRemovida($event)"> 
							<th style="max-width:20px">ID</th>
	                        <th pesquisavel>Nome</th>
	                        <th pesquisavel>Descrição</th>  
	                        <th class="text-center">Ações</th>
						</datatableService> 
					</div>    
				</crudCard> 
 
				<formAdicionarPermissao v-if="permissoes.length > 0" v-on:permissaoAdicionada="permissaoAdicionada($event)" :permissoes="permissoes" :url="url"> </formAdicionarPermissao>   
 
				<h3>Histórico de Permissão</h3>
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config2" id="datatablePerfisPermissaoLog" :reload="permissoes" > 
							<th style="max-width:20px">ID</th>  
	                        <th pesquisavel>Responsável</th>
	                        <th pesquisavel>Ação</th>
	                        <th pesquisavel>Perfil</th>
	                        <th pesquisavel>Usuario</th>
	                        <th pesquisavel>Data</th>
	                        <th pesquisavel>IP</th>
	                        <th pesquisavel>Host</th>
						</datatableService> 
					</div>    
				</crudCard> 
 
			</div> 
		</div>   
	</div>
</template>


<script>
 
// Vue.component('permissaoDatatable', require('./_PermissaoDatatable.vue'));
// Vue.component('permissaoDatatableLog', require('./_PermissaoDatatableLog.vue')); 
Vue.component('formAdicionarPermissao', require('./_PermissaoFormAdicionar.vue'));


export default {

	props:[
	'url' 
	], 

	data() {
		return {        
			perfil:'', 
			permissoes:'',
			config: {
				exclusao:{
					url:this.url + '/' + this.$route.params.id + '/delete/permissao'  ,
					evento:'permissaoRemovida',
					item:'Permissão',
				},
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + '/' + this.$route.params.id + '/permissao/datatable'
				},
				columns: [
				{ data: 'id', name: 'id'  },
				{ data: 'nome', name: 'nome' },
				{ data: 'descricao', name: 'descricao' }, 
				{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
				],
			} ,

			config2: {
				lengthMenu:[
				        [5, 10, 50, -1],
				        [5, 10, 50, "Todos"]
				    ],
				order: [[ 0, "asc" ]],
				ajax: { 
					url: this.url + '/' + this.$route.params.id + '/permissao/log/datatable'
				},
				columns: [
                { data: 'id', name: 'id'  },
                { data: 'autor.name', name: 'autor.name'  },
                { data: 'acao', name: 'acao'  },
                { data: 'perfil.nome', name: 'perfil.nome'  },
                { data: 'permissao_nome', name: 'permissao_nome'  },
                { data: 'created_at', name: 'created_at'  },
                { data: 'ip_v4', name: 'ip_v4'  },
                { data: 'host', name: 'host'  },
               
                 
				],
			} ,    

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
 	h3{
		padding-top: 50px;
		text-align: center;
	}
 </style>