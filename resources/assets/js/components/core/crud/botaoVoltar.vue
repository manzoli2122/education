<template>  
	<router-link  :to="url" exact  class="btn btn-secondary">
		<i class="fa fa-reply"></i> Voltar
	</router-link>	
</template>

<script>



export default {

	props:[
	'url' 
	], 

}

</script>

<style>

</style>