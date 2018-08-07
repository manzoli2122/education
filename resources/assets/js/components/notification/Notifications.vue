<template>
	<li class="nav-item dropdown">

		<a class="nav-link" data-toggle="dropdown" href="#">
			<i class="fa fa-bell-o"></i>
			<span class="badge badge-warning navbar-badge">{{notifications.length}}</span>
		</a>


		<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
			
			<span class="dropdown-item dropdown-header">{{notifications.length}} Notificações</span>
			
			<div class="dropdown-divider"></div>
			

    		<perfilAdicionadoNotification  v-for="notification in perfilAdicionado" :key="notification.id" :notification="notification">  
    		</perfilAdicionadoNotification>
 
			 
			
			<div class="dropdown-divider"></div>
			<a   v-if="notifications.length > 0" href="#" class="dropdown-item dropdown-footer" v-on:click="limparNotifications">
				Limpar todas as Notificações
			</a>
		</div>
	</li>
</template>



<script>
	
	Vue.component('perfilAdicionadoNotification', require('./perfilAdicionadoNotification'));


	export default {


		created(){
			this.loadNotifications();
		},


		computed:{
			perfilAdicionado:  function(){
				return this.notifications.filter(
					function( item ){
						return item.type.match('PerfilAdicionado');
					}
				)
			}
		},



		data() {
			return {          
				notifications:[],
			}
		},



		methods: { 

			loadNotifications(  ) {  
				axios.get('/profile/notificacoes')
				.then(response =>{
					this.notifications = response.data;
				})
			} ,  

			limparNotifications(  ) {  
				axios.post('/profile/limpar/notificacoes')
				.then(response =>{
					this.notifications = [];
				})
			} , 

		},


	}

</script>

