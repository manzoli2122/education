<template>             
	<div v-if="usuario"	>  
		<crudHeader :texto="'Usuário - ' + usuario.name ">
			<li class="breadcrumb-item"><router-link to="/" exact><a>Usuários</a></router-link></li> 
			<li class="breadcrumb-item">Perfis</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">   
				<crudCard>
					<div class="card-header text-center">
						<h2 class="card-title">Perfis</h2>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatableService  :config="config" id="datatableUsuariosPerfis" :reload="reloadDatatable" v-on:perfilRemovido="perfilRemovido($event)"> 
							<th style="max-width:50px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>
							<th pesquisavel>Responsável</th>  
							<th class="text-center">Ações</th>
						</datatableService> 
					</div>    
					<div class="card-footer text-right">
						<crudBotaoVoltar url="/" />   
					</div>
				</crudCard>  

				<formAdicionarPerfil v-if="perfis.length > 0" v-on:perfilAdicionado="perfilAdicionado($event)" :perfis="perfis" :url="url"> </formAdicionarPerfil>    

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
				reloadDatatable: false , 
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
					{ data: 'responsavel_id', name: 'perfils.pivot.responsavel_id' }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
					],
				} ,  


			}
		},

		watch: { 
			usuario: function (newQuestion, oldQuestion) {
				this.buscarPerfis();
			}
		},
 
		created() { 
			alertProcessando();
			axios.get(this.url + '/usuario/' + this.$route.params.id)
			.then(response => {
				alertProcessandoHide();
				this.usuario = response.data; 
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Usuário', error.response.data);
				alertProcessandoHide();
				this.$router.push('/');
			});  
		}, 

		methods: {

			perfilRemovido(event) {
				this.perfis = event;  
			},

			perfilAdicionado(event) {
				this.perfis = event;
				this.reloadDatatable = !this.reloadDatatable; 
			},

			buscarPerfis() {
				alertProcessando();
				axios.get(this.url + "/" + this.$route.params.id + "/perfil/adicionar")
				.then(response => {
					this.perfis = response.data;
					alertProcessandoHide();
				})
				.catch(error => {
					toastErro("Não foi possivel achar os Perfis para adiocionar", error.response.data);
					alertProcessandoHide();
				}); 
			},

		},

	}

</script>

<style scoped>  
</style>