<template>             
	<div>  
		<crudHeader texto="Notificações">
			<li class="breadcrumb-item"><router-link to="/" exact><a>User Profile</a></router-link></li> 
			<li class="breadcrumb-item">Notificações</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">   
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableUsuarios"> 
							<th pesquisavel>Nome</th> 
							<th pesquisavel>Descrição</th>  
							<th style="min-width:90px" class="text-center">Ações</th>
						</datatableService> 
					</div>    
				</crudCard>   
			</div> 
		</div>  
	</div>
</template>


<script>


	export default {

		props:[ 
		'url' , 'user'
		],  

		data() {
			return {    

				config: {
					ativacao:{
						url:this.url , 
						item:'Notificação',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: this.url +  '/notificacao/datatable'
					},
					columns: [ 
					{ data: 'nome', name: 'nome' },
					{ data: 'descricao', name: 'descricao' }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
					],
				} ,  


			}
		},


		created() { 


		}, 



	}

</script>

<style scoped>  
</style>