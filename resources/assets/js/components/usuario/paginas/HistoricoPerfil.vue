<template>             
	<div>  
		<crudHeader :texto="'Usuário ' + usuario.name ">
			<li class="breadcrumb-item"><router-link to="/" exact><a>Usuários</a></router-link></li> 
			<li class="breadcrumb-item">
				<router-link :to="'/' + this.$route.params.id + '/perfil'" exact><a>Perfis</a></router-link>
			</li>
			<li class="breadcrumb-item">Histórico</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">  
				<crudCard>
					<div class="card-header text-center">
						<h3 class="card-title">Histórico de Perfis</h3>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableUsuariosPerfisLog">  
							<th pesquisavel>Responsável</th>
							<th pesquisavel>Ação</th>
							<th pesquisavel>Perfil</th> 
							<th pesquisavel>Data</th>
							<th pesquisavel>IP</th>
							<th pesquisavel>Host</th>
						</datatableService> 
					</div>  
					<div class="card-footer text-right">
						<crudBotaoVoltar :url="'/' + this.$route.params.id + '/perfil'" />   
					</div>  
				</crudCard > 
			  	
			  	<h3>Histórico de Perfil elasticsearch</h3>
			  	<crudCard>
			  		<div v-if="logs" class="card-body  table-responsive"> 
			  			<table class="table table-bordered" id="users-table">
			  				<thead>
			  					<tr>
			  						<th>Id</th>
			  						<th>Responsável</th>
			  						<th>Ação</th>
			  						<th>Perfil</th>
			  						<th>Ip</th>
			  						<th>Data</th>
			  					</tr>
			  				</thead>
			  				<tbody> 
			  					<tr v-for="hit in logs" :key="hit._id">
			  						<td>{{ hit._id}}</td>
			  						<td>{{ hit._source.info.usuario.name}}</td>
			  						<td>{{ hit._source.acao}}</td>
			  						<td>{{ hit._source.dados.dado2.perfil.nome}}</td>
			  						<td>{{ hit._source.info.ip}}</td>
			  						<td>{{ hit._source.data}} </td>
			  					</tr> 
			  				</tbody>
			  			</table> 
			  		</div> 
			  	</crudCard> 		
			</div> 
		</div>  
	</div>
</template>


<script>
   
export default {
 
	props:[ 
	'url' 
	],  

	data() {
		return {   
			logs:'', 
			usuario:'', 

			config: { 
				order: [[ 4, "desc" ]],
				ajax: { 
					url: this.url + '/' + this.$route.params.id + '/perfil/log/datatable'
				},
				columns: [ 
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
 
		this.pesquisaElastic();
		  
	}, 

	methods: {
 
		pesquisaElastic(){
 
			axios.get(this.url + "/" + this.$route.params.id + "/log/elasticsearch")
				.then(response => {
					this.logs = response.data;
				})
				.catch(error => {
					toastErro("Não foi possivel achar log de Perfil", error.response.data);
				});  
		},

	},

 }
 
 </script>
 
 <style scoped> 
 </style>