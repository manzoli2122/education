<template>             
	<div> 
		<crudHeader :texto="model.name">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Usuário </a></router-link> 
			</li>
			<li class="breadcrumb-item active">{{model.name}}</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body">
						<section class="row">    
							<div class="col-12 col-sm-12 ">
								<h4>Email: {{model.email}} </h4>
							</div>   
						</section>  
					</div> 
					<div class="card-footer text-right">
						<crudBotaoVoltar url="/" />  
						
						 
						<router-link   :to="'/'+ $route.params.id + '/perfil'" exact class="btn btn-warning"><a> <i class="fa fa-id-card"></i> Perfil </a></router-link>

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
 			toastErro('Não foi possivel achar o Usuário' , error.response.data);
 			alertProcessandoHide();
 		}); 
 	}, 

 }
 
 </script>
 
 <style scoped>
 
 </style>