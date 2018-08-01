<template>             
	<div>  
		<crudHeader :texto="'Perfis do usuário ' + usuario.name ">
			<li class="breadcrumb-item"><router-link to="/" exact><a>Usuários</a></router-link></li> 
			<li class="breadcrumb-item">Perfis</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">   
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableUsuariosPerfis" :reload="reloadDatatable" v-on:perfilRemovido="perfilRemovido($event)"> 
							<th style="max-width:20px">ID</th>
                        	<th pesquisavel>Nome</th>
                        	<th pesquisavel>Descrição</th>  
                        	<th class="text-center">Ações</th>
						</datatableService> 
					</div>    
					<div class="card-footer text-right">
        				<crudBotaoVoltar url="/" />   
        			</div>
				</crudCard>  
 
				<formAdicionarPerfil v-if="perfis.length > 0" v-on:perfilAdicionado="perfilAdicionado($event)" :perfis="perfis" :url="url"> </formAdicionarPerfil>    
				<h3>Histórico de Perfil</h3>
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config2" id="datatableUsuariosPerfisLog" :reload="reloadDatatableLog" > 
							<th style="max-width:20px">ID</th>  
							<th pesquisavel>Responsável</th>
							<th pesquisavel>Ação</th>
							<th pesquisavel>Perfil</th> 
							<th pesquisavel>Data</th>
							<th pesquisavel>IP</th>
							<th pesquisavel>Host</th>
						</datatableService> 
					</div>  

				</crudCard > 
			  		
			  	<crudCard>
			  		<div v-if="logs" class="card-body  table-responsive"> 
			  			<div v-for="hit in logs.hits.hits">
			  				{{ hit._source.data}} 
			  				{{ hit._id}} 
			  				{{ hit._source.info.usuario.name}}
			  				{{ hit._source.acao}}
			  				{{ hit._source.dados.dado2.perfil.nome}}
			  				{{ hit._source.info.ip}}
			  				{{ hit._source.info.host}}
			  			</div>
			  		</div> 
			  	</crudCard> 		
			</div> 
		</div>  
	</div>
</template>


<script>
  
Vue.component('formAdicionarPerfil', require('./_PerfilFormAdicionar.vue'));  

export default {
 
	props:[ 
	'url' 
	],  

	data() {
		return {   
			logs:'', 
			usuario:'',
			perfis:'', 
			reloadDatatable: false ,
			reloadDatatableLog: false ,
			config: {
				exclusao:{
					url:this.url + '/' + this.$route.params.id + '/delete/perfil'  ,
					evento:'perfilRemovido',
					item:'Perfil',
				},
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + '/' + this.$route.params.id + '/perfil/datatable'
				},
				columns: [
				{ data: 'perfil_id', name: 'perfils_users.perfil_id'  },
				{ data: 'nome', name: 'perfils.nome' },
				{ data: 'descricao', name: 'perfils.descricao' }, 
				{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
				],
			} ,  

			config2: {
				lengthMenu:[
				        [5, 10, 50, -1],
				        [5, 10, 50, "Todos"]
				    ],
				order: [[ 4, "desc" ]],
				ajax: { 
					url: this.url + '/' + this.$route.params.id + '/perfil/log/datatable'
				},
				columns: [
                { data: 'id', name: 'usuario_perfil_log.id'  },
                { data: 'autor.name', name: 'autor.name'  },
                { data: 'acao', name: 'usuario_perfil_log.acao'  },
                { data: 'perfil.nome', name: 'perfil.nome'  }, 
                { data: 'created_at', name: 'created_at'  },
                { data: 'ip_v4', name: 'ip_v4'  },
                { data: 'host', name: 'host'  }, 
				],
			} ,   
		}
	},
  

	created() { 
		alertProcessando();
		axios.get(this.url + '/' + this.$route.params.id)
		.then(response => {
			this.usuario = response.data;
			alertProcessandoHide();
		})
		.catch(error => {
			toastErro('Não foi possivel achar o Usuário', error.response.data);
			alertProcessandoHide();
		}); 

		axios.get(this.url + "/" + this.$route.params.id + "/perfil/adicionar")
		.then(response => {
			this.perfis = response.data;
		})
		.catch(error => {
			toastErro("Não foi possivel achar a Perfil", error.response.data);
		});  

 
		this.pesquisaElastic();
		

		 



	}, 

	methods: {

		perfilRemovido(event) {
			this.perfis = event; 
			this.reloadDatatableLog = !this.reloadDatatableLog;
		},

		perfilAdicionado(event) {
			this.perfis = event;
			this.reloadDatatable = !this.reloadDatatable;
			this.reloadDatatableLog = !this.reloadDatatableLog;

			this.pesquisaElastic();
		},

		pesquisaElastic(){
			var query = {
				"query":{ 
					"bool": {
						"must":[
							{"match": {	"dados.dado1.usuario.id": this.$route.params.id	} } 							 
						],
						"should": [
							{"match": {"acao": "adicionarPerfilAoUsuario" } },
							{"match": {"acao": "excluirPerfilDoUsuario" } }
						]
					} 	
				}  	 
			}

			query = JSON.stringify(query);
 
			let vm = this;
			$.ajax({
				url: "http://localhost:9200/education/education/_search",
				method: 'post',

				contentType: 'application/json',
				dataType: 'json',  
				data: query,
				success: function(data) { 
					vm.logs = data;

				}
			});
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