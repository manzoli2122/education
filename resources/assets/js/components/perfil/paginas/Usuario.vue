<template>             
	<div> 
		<crudHeader :texto="model.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perfil </a></router-link> 
			</li>
            <li class="breadcrumb-item">
				<router-link   :to="'/show/'+ $route.params.id" exact><a>{{model.nome}} </a></router-link> 
			</li> 
            <li class="breadcrumb-item active">Usuario</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
                    <div class="card-header">
                        <h4 class="text-center"> Permissões </h4>
                    </div>
					<div class="card-body">
 
						<section v-for="usuario in usuarios" :key="usuario.id" class="row">    
							<div class="col-6 col-sm-6 ">
								<h4>  {{usuario.name}} </h4>
							</div>     
							<div class="col-6 col-sm-6 ">
								<h4>  {{usuario.email}} </h4>
							</div> 
						</section>  
 
					</div> 
 
					<div class="card-footer text-right">
						<crudBotaoVoltar :url="'/show/' + $route.params.id" />  
						<!-- <crudBotaoExcluir :url="url + '/' + $route.params.id"></crudBotaoExcluir> -->
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
            usuarios:'',
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
 			toastErro('Não foi possivel achar a Perfil' , error.response.data);
 			alertProcessandoHide();
         }); 
         

        axios.get(this.url + '/' + this.$route.params.id +'/usuario')
 		.then(response => {
 			this.usuarios = response.data ;
 		})
 		.catch(error => {
 			toastErro('Não foi possivel achar a Usuarios' , error.response.data);
         }); 
         

 	}, 

 }
 
 </script>
 
 <style scoped>
 
 </style>