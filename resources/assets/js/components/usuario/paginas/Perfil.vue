<template>             
	<div>  
		<crudHeader :texto="'Perfis do usuário ' + usuario.name ">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Usuários </a></router-link> 
			</li> 
			<li class="breadcrumb-item"> Perfis </li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">  
				 
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableUsuariosPerfis" :reload="perfis" v-on:perfilRemovido="buscarPerfilParaAdicionar($event)"> 
							<th style="max-width:20px">ID</th>
                        	<th pesquisavel>Nome</th>
                        	<th pesquisavel>Descrição</th>  
                        	<th class="text-center">Ações</th>
						</datatableService> 
					</div>    
				</crudCard>  
 
				<formAdicionarPerfil v-if="perfis.length > 0" v-on:perfilAdicionado="perfilAdicionado($event)" :perfis="perfis" :url="url"> </formAdicionarPerfil>    
				<h3>Histórico de Perfil</h3>
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config2" id="datatableUsuariosPerfisLog" :reload="perfis" > 
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
  
Vue.component('formAdicionarPerfil', require('./_PerfilFormAdicionar.vue'));  

export default {
 
	props:[ 
	'url' 
	],  

	data() {
		return {    
			usuario:'',
			perfis:'', 
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
				order: [[ 0, "asc" ]],
				ajax: { 
					url: this.url + '/' + this.$route.params.id + '/perfil/log/datatable'
				},
				columns: [
                { data: 'id', name: 'usuario_perfil_log.id'  },
                { data: 'autor.name', name: 'autor.name'  },
                { data: 'acao', name: 'usuario_perfil_log.acao'  },
                { data: 'perfil.nome', name: 'perfil.nome'  },
                { data: 'usuario.name', name: 'usuario.name'  },
                { data: 'created_at', name: 'created_at'  },
                { data: 'ip_v4', name: 'ip_v4'  },
                { data: 'host', name: 'host'  },
               
                 
				],
			} ,   
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

		axios.get(this.url + "/" + this.$route.params.id + "/perfil/adicionar")
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
		},

		perfilAdicionado(event) {
			this.perfis = event;
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