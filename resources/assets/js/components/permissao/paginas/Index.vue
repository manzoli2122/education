<template>  
	<div>  
		<crudHeader texto="Permissões Cadastradas">
			<li class="breadcrumb-item">Permissoes 	</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatablePermissao"> 
							<th style="max-width:20px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descricao</th>  
							<th class="text-center">Ações</th>
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
				exclusao:{
					url:this.url,
					evento:'permissaoRemovida',
					item:'Permissão',
				},
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + '/datatable'
				},
				columns: [
				{ data: 'id', name: 'id'  },
				{ data: 'nome', name: 'nome' },
				{ data: 'descricao', name: 'descricao' }, 
				{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
				],
			} , 
			reload:'',
		}
	}, 
}

</script>
 
<style > 
.btn-sm{
	 margin-left: 10px; 
}
</style>