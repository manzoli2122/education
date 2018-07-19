<template>             
	<div> 
		<crudHeader :texto="model.name">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Usuário </a></router-link> 
			</li>
            <li class="breadcrumb-item">
				<router-link   :to="'/show/'+ $route.params.id" exact><a>{{model.name}} </a></router-link> 
			</li> 
            <li class="breadcrumb-item active">Perfis</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 

                <Formulario :url="url" :form="form" metodo="post"> 
                    <crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
						<label for="nome">Nome:</label>
						<input type="text" id="nome" name="nome" class="form-control" v-model="form.nome" v-bind:class="{ 'is-invalid': form.errors.has('nome') }"> 
					</crudFormElemento>  
                    <crudFormElemento :errors="form.errors.has('descricao')" :errors_texto="form.errors.get('descricao')">
						<label for="descricao">Perfis:</label>
						 
                         <select2   v-model="form.descricao" multiple="multiple" class="form-control" v-bind:class="{ 'is-invalid': form.errors.has('descricao') }"> 
                            <option   value="Muito Facil"> Muito Fácil </option>
                            <option   value="Facil"> Fácil </option>
                            <option   value="Medio"> Medio </option>
                            <option   value="Dificil">   Difícil </option>
                            <option   value="Muito Dificil"> Muito Difícil </option>
                            <option v-for="disc in permissoes" :key="disc.id"   :value="disc.id"> {{disc.nome}} </option>
                        </select2>
                    </crudFormElemento>   
				</Formulario>  
				<crudCard>
                    <div class="card-header">
                        <h4 class="text-center"> Perfil </h4>
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
					</div>     
				</crudCard> 
			</div> 
		</div>   
	</div>
</template>


<script>
import Form from '../../core/Form'; 
export default {

	props:[
	'url' 
	], 

	data() {
		return {                
            model:'', 
            permissoes:'',
            form: new Form({
				nome: '',    
				descricao: ''               
			}),
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
         

        axios.get(this.url + '/' + this.$route.params.id +'/perfil/cadastrar')
 		.then(response => {
 			this.permissoes = response.data ;
 		})
 		.catch(error => {
 			toastErro('Não foi possivel achar a Perfil' , error.response.data);
         }); 
         

 	}, 

 }
 
 </script>
 
 <style scoped>
 
 </style>