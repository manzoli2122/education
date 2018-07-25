<template>  
	<button class="btn btn-danger" v-on:click="alertConfimacao">
		<i class="fa fa-trash"></i> {{message}}
	</button>
</template>

<script>
 
export default {

	props:[
	'url'  , 'texto'
	], 

	methods: {

		computed: { 
			message: function () { 
				if(this.texto){
					return this.texto;
				}
				return 'Excluir'; 
			}
		},
		
		alertConfimacao (  ) {
			let vm = this;

			alertConfimacao('Confirma a Exclusão ','', vm.excluirItem() );

/*
			iziToast.show({
				theme: 'dark',
				color: '#3C8DBC',
				titleColor: '#fff',
				messageColor: '#fff',
				timeout: false,
				icon: 'fa fa-question-circle-o',
				iconColor: '#fff',
				close: false,
				overlay: true,
				toastOnce: true,
				zindex: 999,
				title:  'Confirma a Exclusão do Disciplina' ,
				message: '', 
				position: 'center',   
				buttons: [
				['<button>Sim</button>', function (instance, toast) {
					instance.hide( {
						transitionOut: 'fadeOut'
					},toast, 'buttonName'); 
					vm.excluirItem(); 
				}, true],  
				['<button>Não</button>', function (instance, toast) {
					instance.hide({
						transitionOut: 'fadeOutUp', 
					}, toast, 'buttonName');
				}]
				], 
			}); 
			*/
		},
  
		excluirItem() {
			axios.delete(this.url )
			.then(response => {
				toastSucesso('Item excluido com Sucesso ' ); 
				this.$router.push('/')
			})
			.catch(error => {
				console.log(error.response)
				toastErro(error);
			}); 
		}, 
	} 
}

</script>

<style> 
</style>