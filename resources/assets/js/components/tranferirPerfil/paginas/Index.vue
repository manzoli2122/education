<template>  
	<div>  
		<crudHeader texto="Usuários Cadastrados">
			<li class="breadcrumb-item">Usuários</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableUsuarios"> 
							<th pesquisavel style="max-width:90px">CPF</th>
							<th pesquisavel>RG</th> 
							<th pesquisavel>Post/Grad</th> 
							<th pesquisavel>Nome</th> 
							<th pesquisavel>OME</th>  
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
					{ data: 'rg', name: 'rg'  }, 
					{ data: 'post_grad_dsc', name: 'post_grad_dsc'  }, 
					{ data: 'name', name: 'name' }, 
					{ data: 'ome_qdi_dsc', name: 'ome_qdi_dsc' }, 	
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