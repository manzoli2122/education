<template>  
	<button  class="btn btn-success">
		<i class="fa fa-check"></i> {{message}}
	</button> 
</template>

<script>
	export default {  
		props:[
		'texto'
		],  
		
		computed: { 
			message: function () { 
				if(this.texto){
					return this.texto;
				}
				return 'Salvar'; 
			}
		},


	} 
</script>

<style scoped>
.btn{
	margin-left: 5px;
}
</style>