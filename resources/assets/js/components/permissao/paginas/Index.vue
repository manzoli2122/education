<template>  
	<div>  
		<crudHeader texto="Permissões Cadastradas">
			<li class="breadcrumb-item">
				Permissoes 
			</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config"> 
							<th style="max-width:20px">ID</th>
							<th pesquisavel>Nome</th>
							<th>Descricao</th>  
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
				{ data: 'nome', name: 'nome' },
				{ data: 'descricao', name: 'descricao' }, 
				{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
				],
			} , 
		}
	},

}

</script>
 
<style >

</style>