<template>  
	<button class="btn btn-danger" v-on:click="alertConfimacao">
		<i class="fa fa-trash"></i> Excluir
	</button>
</template>

<script>



export default {

	props:[
	'url' 
	], 

	methods: {

		alertConfimacao (  ) {
			let vm = this;
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
						onClosing: function(instance, toast, closedBy){
							console.info('closedBy: ' + closedBy); 
						}
					}, toast, 'buttonName');
				}]
				],
/*

				onOpening: function(instance, toast){
					console.info('callback abriu!');
				},
				onClosing: function(instance, toast, closedBy){
					console.info('closedBy: ' + closedBy); 
				}

				*/
			});

		},




		excluirItem() {
			axios.delete(this.url )
			.then(response => {
				this.sucesso();
				this.$router.push('/')
			})
			.catch(error => {
				console.log(error.response)
				this.error(error);
			}); 
		},


		sucesso(){
			iziToast.show({
				theme: 'dark',
				timeout: 2000,
				position: 'center' ,
				color: '#00A65A',
				title: 'Item excluido com Sucesso',
				titleColor: '#fff',
				titleSize: '14',
				message: '',
				messageColor: '#fff', 
				icon: 'fa fa-check',
				iconColor: '#fff',
				closeOnEscape: true,
				//onClosed: funcao
			});

			 
		},


		error(error){
			iziToast.show({
				theme: 'dark',
				position: 'center',
				color: '#DD4B39',
				title: 'Não foi possivel Excluir' + error.response.data ,
				titleColor: '#fff',
				titleSize: '14',
				message: '',
				messageColor: '#fff',
				timeout: 2000,
				icon: 'fa fa-ban',
				iconColor: '#fff',
				closeOnEscape: true,
				//onClosed: funcao
			});
		},


/*
		alertConfimacaoSweet(    ) {
			swal({
				title: 'Confirma a Exclusão do Disciplina',
				text: '',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Sim'
			}).then((result) => {
				if (result.value) { 
					axios.delete(this.url )
					.then(response => {
						alert('ok')
						this.$router.push('/')
					})
					.catch(error => {
						alert('nao ok')
						this.$router.push('/')
					});   
				}
			})
		},

		*/
	}

}

</script>

<style>

</style>