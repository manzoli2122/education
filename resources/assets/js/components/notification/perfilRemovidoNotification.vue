<template>
	<div >
		<a href="#" class="dropdown-item" v-on:click="display()">
			<i class="fa fa-envelope mr-2"></i>{{notification.data.title }}  
		</a>
	</div>
</template>



<script>

	export default {
 
		props:[
		'notification'
		] ,


		methods:{
			display(){
				
				let data = {}; 
				data['id'] = this.notification.id; 
				axios.post('/profile/notificacoes' ,data)
				.then(response =>{
					// this.notifications = response.data;
					this.$emit('visualizado' ) 
					console.log('leu notificação');
				})
				// swal( 
				// 	this.notification.data.title,
				// 	this.notification.data.message,

				// );

				swal({
					//type: 'error',
					title: this.notification.data.title ,
					text:this.notification.data.message,
					imageUrl: '/img/perca.gif',
					imageWidth: 200,
					imageHeight: 200,
					width: 600,
					padding: '3em',
					confirmButtonColor: '#f00506',
					//background: '#fff url(/img/dare.png)',
					// backdrop: `
					// rgba(0,0,123,0.4)
					// url("/img/perca.gif")
					// center right
					// no-repeat
					// `
				})
			}
		}

	}

</script>

