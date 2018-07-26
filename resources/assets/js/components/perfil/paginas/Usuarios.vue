<template>             
	<div> 
		<crudHeader :texto="'Usuários do perfil ' + perfil.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perfis </a></router-link> 
			</li> 
            <li class="breadcrumb-item active">Usuários</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body  table-responsive">  
						<datatableService :config="config" id="datatableUsuarios"> 
							<th style="max-width:20px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Email</th>  
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
				{ data: 'id', name: 'id'  },
				{ data: 'name', name: 'name' },
				{ data: 'email', name: 'email' },  
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