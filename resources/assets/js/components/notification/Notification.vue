<template>
	<div >
		<a href="#" class="dropdown-item">
			<i class="fa fa-envelope mr-2"></i> {{notification.perfil.nome}}
			<span class="float-right text-muted text-sm">3 mins</span>
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

