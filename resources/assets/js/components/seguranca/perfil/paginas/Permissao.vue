<template>             
	<div v-if="perfil"> 
		<crudHeader :texto="'Perfil - ' + perfil.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perfis </a></router-link> 
			</li> 
			<li class="breadcrumb-item active">Permissões</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">  
				<crudCard>
					<div class="card-header text-center">
						<h2 class="card-title">Permissões</h2>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatablePerfisPermissao" :reload="reloadDatatable" v-on:permissaoRemovida="permissaoRemovida($event)"> 
							<th style="max-width:30px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>  
							<th class="text-center">Ações</th>
						</datatableService> 
					</div>    
					<div class="card-footer text-right">  
						<crudBotaoVoltar url="/" />   
						<router-link :to="'/' + this.$route.params.id + '/permissao/historico'" exact  class="btn btn-warning">
							<i class="fa fa-database"></i> Historico
						</router-link>
					</div>  
				</crudCard> 
				<formAdicionarPermissao v-if="permissoes.length > 0" v-on:permissaoAdicionada="permissaoAdicionada($event)" :permissoes="permissoes" :url="url"> </formAdicionarPermissao>  
			</div> 
		</div>   
	</div>
</template>


<script>

	Vue.component('formAdicionarPermissao', require('./_PermissaoFormAdicionar.vue'));

	export default {

		props:[
		'url' 
		], 

		data() {
			return {        
				perfil:'', 
				permissoes:'',
				reloadDatatable: false ,
				reloadDatatableLog: false ,
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

			}
		},

		watch: { 
			perfil: function (newQuestion, oldQuestion) {
				this.buscarPermissoes();
			}
		},



		created() {
			alertProcessando();
			axios.get(this.url + '/' + this.$route.params.id )
			.then(response => {
				alertProcessandoHide();
				this.perfil = response.data ;  
			})
			.catch(error => { 
				alertProcessandoHide();
				toastErro('Não foi possivel achar a Perfil' , error.response.data);
				this.$router.push('/');
			});   

		}, 




		methods: {

			permissaoRemovida(event) {
				this.permissoes = event;  
			},

			permissaoAdicionada(event) {
				this.permissoes = event;
				this.reloadDatatable = !this.reloadDatatable; 
			},

			buscarPermissoes() {
				alertProcessando();
				axios.get(this.url + '/' + this.$route.params.id +'/permissao/adicionar')
				.then(response => {
					this.permissoes = response.data ;
					alertProcessandoHide();
				})
				.catch(error => {
					toastErro('Não foi possivel achar a Permissoes' , error.response.data);
					alertProcessandoHide();
				});
 
			},



		},

	}

</script>

<style scoped> 
</style>