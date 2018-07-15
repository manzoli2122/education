<template>   
	<div class="form-group">
		<slot></slot>
		<div class="invalid-feedback" v-if="errors" v-text="errors_texto"></div>
	</div> 
</template>

<script> 
	export default { 
		props:[
		'errors' , 'errors_texto'
		],  
	} 
</script>

<style> 
</style>