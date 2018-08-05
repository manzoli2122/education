<template> 
	<form action="#" @submit.prevent="AdicionarPerfil" @keydown="form.errors.clear($event.target.name)">
		<h3>Adicionar Perfil</h3>
		<crudCard>
			<div class="card-body">
				<crudFormElemento :errors="form.errors.has('perfil')" :errors_texto="form.errors.get('perfil')">

					<select2 v-model="form.perfil" class="form-control" v-bind:class="{ 'is-invalid': form.errors.has('perfil') }">
						<option value=""> Selecione o Perfil </option>
						<option v-for="p in perfis" :key="p.id" :value="p.id"> {{p.nome}} </option>
					</select2>
				</crudFormElemento>
			</div>
			<div class="card-footer text-right">
				<crudBotaoSalvar :disabled="form.errors.any()" texto="Adicionar"/>
			</div>
		</crudCard>
	</form> 
</template>


<script>

	import Form from "../../core/Form";

	export default {

		props: ["url", "perfis"],

		data() {
			return {
				form: new Form({
					perfil: ""
				})
			};
		},



		methods: {

			AdicionarPerfil() {
				if (this.form.perfil) {
					this.form.submit("post", this.url + "/" + this.$route.params.id + "/adicionar/perfil")
					.then(response => { 
						toastSucesso("Perfil adicionado com successo."); 
						this.$emit('perfilAdicionado', response ) 
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