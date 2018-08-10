<template>             
	<div> 
		<crudHeader :texto="'Perfil ' + perfil.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perfis </a></router-link> 
			</li> 
			<li class="breadcrumb-item">
				<router-link :to="'/' + this.$route.params.id + '/permissao'" exact><a>Permissões</a></router-link>
			</li>
			<li class="breadcrumb-item active">Historico</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				 
				<crudCard>
					<div class="card-header text-center">
						<h3 class="card-title">Histórico de Permissão</h3>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatablePerfisPermissaoLog" >  
							<th pesquisavel>Responsável</th>
							<th pesquisavel>Ação</th> 
							<th pesquisavel>Permissão</th>
							<th pesquisavel>Data</th>
							<th pesquisavel>IP</th>
							<th pesquisavel>Host</th>
						</datatableService> 
					</div> 
					<div class="card-footer text-right">
						<crudBotaoVoltar :url="'/' + this.$route.params.id + '/permissao'" />   
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
			perfil:'',  
			config: { 
				order: [[ 4, "desc" ]],
				ajax: { 
					url: this.url + '/' + this.$route.params.id + '/permissao/log/datatable'
				},
				columns: [ 
				{ data: 'autor.name', name: 'autor.name'  },
				{ data: 'acao', name: 'acao'  }, 
				{ data: 'permissao_nome', name: 'permissao_nome'  },
				{ data: 'created_at', name: 'created_at'  },
				{ data: 'ip_v4', name: 'ip_v4'  },
				{ data: 'host', name: 'host'  }, 
				],
			} ,    

		}
	},
 
	created() {
		alertProcessando();
		axios.get(this.url + '/' + this.$route.params.id )
		.then(response => {
			this.perfil = response.data ;
			alertProcessandoHide();
		})
		.catch(error => { 
			alertProcessandoHide();
 			toastErro('Não foi possivel achar a Perfil' , error.response.data);
 		});  
	}, 
 
}

</script>

<style scoped>
 
</style>