<template>  
	<router-link  :to="url" exact  class="btn btn-secondary">
		<i class="fa fa-reply"></i> {{message}}
	</router-link>	
</template>

<script> 

	export default {

		props:[
		'url' , 'texto'
		], 

		computed: { 
			message: function () { 
				if(this.texto){
					return this.texto;
				}
				return 'Voltar'; 
			}
		},

	}

</script>

<style> 
</style>