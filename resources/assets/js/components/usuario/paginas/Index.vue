<template>  
	<div>  
		<crudHeader texto="Usuários Cadastrados">
			<li class="breadcrumb-item">
				Usuários  
			</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config"> 
							<th style="max-width:20px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Email</th>  
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
					url: this.url + '/datatable'
				},
				columns: [
				{ data: 'id', name: 'id'  },
				{ data: 'name', name: 'name' },
				{ data: 'email', name: 'email' }, 
				{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
				],
			} , 
		}
	},

}

</script>
 
<style >
.btn-sm{
	 margin-left: 10px; 
}
</style>