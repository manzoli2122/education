<template>             
	<div> 
		<crudHeader :texto="'Perfil ' + perfil.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perfis </a></router-link> 
			</li> 
            <li class="breadcrumb-item active">Usuários</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-header text-center">
						<h3 class="card-title">Usuários</h3>  
					</div>
					<div class="card-body  table-responsive">  
						<datatableService :config="config" id="datatableUsuarios">  
							<th pesquisavel>CPF</th> 
							<th pesquisavel>RG</th> 
							<th pesquisavel>Posto/Graduação</th> 
							<th pesquisavel>Nome</th> 
							<th pesquisavel>OME</th> 
						</datatableService>  
					</div> 
					<div class="card-footer text-right">
						<crudBotaoVoltar url="/" />   
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
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url+ '/' + this.$route.params.id + '/usuarios/datatable'
				},
				columns: [
				{ data: 'user_id', name: 'id'  }, 
				{ data: 'rg', name: 'rg'  }, 
				{ data: 'post_grad_dsc', name: 'post_grad_dsc'  }, 
				{ data: 'name', name: 'name' }, 
				{ data: 'ome_qdi_dsc', name: 'ome_qdi_dsc' }, 
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