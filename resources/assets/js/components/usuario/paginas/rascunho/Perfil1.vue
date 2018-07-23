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
						<router-link   :to="'/'+ $route.params.id + '/perfil/adicionar'" exact class="btn btn-warning">
							<a> <i class="fa fa-plus"></i> Adicionar Perfil </a>
						</router-link>
 
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
 			toastErro('Não foi possivel achar o Usuário' , error.response.data);
 			alertProcessandoHide();
         }); 
         

        axios.get(this.url + '/' + this.$route.params.id +'/perfil')
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
















 <template>             
	 <div>  
		<crudHeader :texto="'Perfis dos ' + model.name ">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Usuário </a></router-link> 
			</li>
			<li class="breadcrumb-item active">{{model.name}}</li>
			<li class="breadcrumb-item">
				Perfis  
			</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config"> 
							<th style="max-width:20px">ID</th>
							<th pesquisavel>Nome</th>
							<th>Descrição</th>  
							<th class="text-center" style="width:200px">Ações</th>
						</datatable> 
					</div>    
				</crudCard> 
   
				<form action="#" @submit.prevent="AdicionarPerfil" @keydown="form.errors.clear($event.target.name)">
					<crudCard>
						<div class="card-body"> 
							<crudFormElemento :errors="form.errors.has('perfil')" :errors_texto="form.errors.get('perfil')">
								<label for="descricao">Perfis:</label> 
								<select2   v-model="form.perfil" class="form-control" v-bind:class="{ 'is-invalid': form.errors.has('descricao') }">
									<option value=""> Selecione o Perfil </option>
									<option v-for="disc in perfis" :key="disc.id"   :value="disc.id"> {{disc.nome}} </option>
								</select2>
							</crudFormElemento>
						</div>
						<div class="card-footer text-right"> 
							<crudBotaoSalvar :disabled="form.errors.any()" /> 
						</div>
					</crudCard> 
				</form>  



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
			config: {
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + '/' + this.$route.params.id + '/perfil'
				},
				columns: [
				{ data: 'id', name: 'id'  },
				{ data: 'nome', name: 'nome' },
				{ data: 'descricao', name: 'descricao' }, 
				{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
				],
			} , 

			perfis:'',
			model:'', 
			form: new Form({
				perfil: '',    
				               
			}),
		}
	},
 
 	created() {
		 
		axios.get(this.url + '/' + this.$route.params.id )
 		.then(response => {
 			this.model = response.data ;
 		})
 		.catch(error => {
 			//console.log(error.response);
 			toastErro('Não foi possivel achar o Usuário' , error.response.data);
 			alertProcessandoHide();
		});


		 

        axios.get(this.url + '/' + this.$route.params.id +'/perfis_ori2')
 		.then(response => {
 			this.permissoes = response.data ;
 		})
 		.catch(error => {
 			toastErro('Não foi possivel achar a Permissoes' , error.response.data);
         }); 
         



		axios.get(this.url + '/' + this.$route.params.id +'/perfil/cadastrar')
 		.then(response => {
 			this.perfis = response.data ;
 		})
 		.catch(error => {
 			toastErro('Não foi possivel achar a Perfil' , error.response.data);
         }); 
         
	 }, 
	 






	 methods: {

			AdicionarPerfil() {
				this.form.submit( 'post' , this.url + '/' + this.$route.params.id + '/perfil/cadastrar' )
				.then(response => {
					swal({ 
						type: 'success',
						showCloseButton: true,
						title: 'Disciplina Cadastrada com sucesso!!',
						timer: 5000,
						width: 400, 
						confirmButtonColor: '#646464',
						confirmButtonText: '<h4>OK</h4>',
						confirmButtonClass: 'bg-green', 
					}) ;
					 
					})
				.catch(errors => console.log(errors));
			} ,


			ExcluirPerfil( id ) {

				axios.get(this.url + '/' + this.$route.params.id +'/perfil/' +  id + '/delete')
					.then(response => {
						alert('successos');
						//this.perfis = response.data ;
					})
					.catch(error => {
						toastErro('Não foi possivel achar a Perfil' , error.response.data);
					}); 
		  
			} 





	} 






 }
 
 </script>
 
 <style scoped>
 
 </style>