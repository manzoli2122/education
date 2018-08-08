<template>
	<div >
		<a href="#" class="dropdown-item">
			<i class="fa fa-envelope mr-2"></i> Perfil {{notification.data.perfil.nome}} Removido 
		</a>
	</div>
</template>



<script>

	export default {
 
		props:[
		'notification'
		] 

	}

</script>

