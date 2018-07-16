<template>  
	<div>  
		<crudHeader texto="Listagem das Usuário">
			<li class="breadcrumb-item">
				Perfil  
			</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config"> 
							<th style="max-width:20px">ID</th>
							<th pesquisavel>Nome</th>
							<th>Email</th>  
							<th class="text-center" style="width:200px">Ações</th>
						</datatable> 
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
			config: {
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + '/getDatatable'
				},
				columns: [
				{ data: 'id', name: 'id'  },
				{ data: 'name', name: 'name' },
				{ data: 'email', name: 'email' }, 
				{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			} , 
		}
	},

}

</script>
 
<style >

</style>