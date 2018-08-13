<template>
	<div >
		<a href="#" class="dropdown-item" v-on:click="display()">
			<i class="fa fa-envelope mr-2"></i> {{notification.perfil.nome}}
			<span class="float-right text-muted text-sm">3 mins</span>
		</a> 
	</div>
</template> 

<script>
 
	export default { 
		props:[
		'notification'
		]  ,



		methods:{
			display(){
				swal('Any fool can use a computer');
			}
		}
	}




</script>

