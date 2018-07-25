<template>         
	<form method="POST" action="#" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
		<crudCard>
			<div class="card-body"> 
				 <slot></slot>
			</div>
			<div class="card-footer text-right">
				<crudBotaoVoltar url="/"/>  
				<crudBotaoSalvar :disabled="form.errors.any()" /> 
			</div>
		</crudCard> 
	</form>  
</template>
 
<script> 

	export default {

		props:[
		'url' , 'form' , 'metodo'
		], 
  
		methods: {

			onSubmit() {
				this.form.submit( this.metodo , this.url )
				.then(response => {
					//console.log(response);
					toastSucesso(response);  
					this.$router.push('/')
					})
				.catch(errors => console.log(errors));
			} 
		} 
	} 

</script>
