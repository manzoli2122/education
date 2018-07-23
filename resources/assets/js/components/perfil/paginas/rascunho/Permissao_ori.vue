<template>             
	<div> 
		<crudHeader :texto="model.nome">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perfil </a></router-link> 
			</li>
            <li class="breadcrumb-item">
				<router-link   :to="'/show/'+ $route.params.id" exact><a>{{model.nome}} </a></router-link> 
			</li>
			<!-- <li class="breadcrumb-item active">{{model.nome}}</li> -->
            <li class="breadcrumb-item active">Permissões</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
                    <div class="card-header">
                        <h4 class="text-center"> Permissões </h4>
                    </div>
					<div class="card-body">
 
						<section v-for="permissao in permissoes" :key="permissao.id" class="row">    
							<div class="col-12 col-sm-12 ">
								<h4>  {{permissao.nome}} </h4>
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
            permissoes:'',
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
         

        axios.get(this.url + '/' + this.$route.params.id +'/permissao')
 		.then(response => {
 			this.permissoes = response.data ;
 		})
 		.catch(error => {
 			toastErro('Não foi possivel achar a Permissoes' , error.response.data);
         }); 
         

 	}, 

 }
 
 </script>
 
 <style scoped>
 
 </style>