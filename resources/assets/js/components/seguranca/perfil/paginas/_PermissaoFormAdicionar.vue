<template>
	<form action="#" @submit.prevent="AdicionarPermissao" @keydown="form.errors.clear($event.target.name)">
		<h3>Adicionar Permissão</h3>
		<crudCard> 
			<div class="card-body">
				<crudFormElemento :errors="form.errors.has('permissao')" :errors_texto="form.errors.get('permissao')"> 
					<select2 v-model="form.permissao" class="form-control col-9" v-bind:class="{ 'is-invalid': form.errors.has('permissao') }">
						<option value=""> Selecione a permissão </option>
						<option v-for="p in permissoes" :key="p.id" :value="p.id"> {{p.nome}} </option>
					</select2>
					<crudBotaoSalvar :disabled="form.errors.any()" texto="Adicionar"/>
				</crudFormElemento>
			</div> 
		</crudCard>
	</form>
</template>


<script>

	import Form from "../../../core/Form";

	export default {
		
		props: ["url", "permissoes"],

		data() {
			return {
				form: new Form({
					permissao: ""
				})
			};
		},



		methods: {
			
			AdicionarPermissao() {
				if (this.form.permissao) {
					this.form.submit("post", this.url + "/" + this.$route.params.id + "/adicionar/permissao")
					.then(response => { 
						toastSucesso("Permissão adicionado com successo."); 
						this.$emit('permissaoAdicionada', response ) 
					})
					.catch(errors => console.log(errors));
				}
			},

			
		}
	};
</script>

<style scoped>

h3{
	padding-top: 50px;
	text-align: center;
}
</style>