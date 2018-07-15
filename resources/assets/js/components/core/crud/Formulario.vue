<template>         
	<form method="POST" action="#" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
		<crudCard>
			<div class="card-body"> 
				 <slot></slot>
			</div>
			<div class="card-footer text-right">
				<crudBotaoVoltar/>  
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
					this.$router.push('/')
					})
				.catch(errors => console.log(errors));
			} 
		} 
	} 

</script>
