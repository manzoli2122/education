<template>             
	<div> 
		<crudHeader :texto="model.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Permissão </a></router-link> 
			</li>
			<li class="breadcrumb-item active">{{model.nome}}</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body">
						<section class="row">    
							<div class="col-12 col-sm-12 ">
								<h4>Descrição: {{model.descricao}} </h4>
							</div>     
							<div class="col-12 col-sm-6">
								<h4> Data de Criação: {{model.created_at}} </h4>
							</div>
						</section>  
					</div> 
					<div class="card-footer text-right">
						<crudBotaoVoltar/>  
						<crudBotaoExcluir :url="url + '/' + $route.params.id"></crudBotaoExcluir>
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
			model:'', 
		}
	},

	watch: {
		model: function (newmodel, oldmodel) {
            alertProcessandoHide();
        }
    },   

    created() {
 		alertProcessando();
 		axios.get(this.url + '/' + this.$route.params.id )
 		.then(response => {
 			this.model = response.data ;
 		})
 		.catch(error => {
 			//console.log(error.response);
 			toastErro('Não foi possivel achar a Permissão' , error.response.data);
 			alertProcessandoHide();
 		}); 
 	}, 

 }
 
 </script>
 
 <style scoped>
 
 </style>