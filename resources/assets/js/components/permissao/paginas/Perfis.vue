<template>             
	<div> 
		<crudHeader :texto="'Perfis da Permissao ' + permissao.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Permissão </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Perfis</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatablePerfis"> 
							<th style="max-width:20px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>  
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
            permissao:'', 
            config: {
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url+ '/' + this.$route.params.id + '/perfis/datatable'
				},
				columns: [
				{ data: 'id', name: 'id'  },
				{ data: 'nome', name: 'nome' },
				{ data: 'descricao', name: 'descricao' },  
				],
			} , 
       	}
	},

	 



    created() { 
 		axios.get(this.url + '/' + this.$route.params.id )
 		.then(response => {
 			this.permissao = response.data ;
 		})
 		.catch(error => { 
 			toastErro('Não foi possivel achar a Permissão' , error.response.data); 
 			this.$router.push('/');
         });   
	 }, 
	 
 

 }
 
 </script>
 
 <style scoped>
 
 </style>