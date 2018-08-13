<template>
	 
	 
	<li class="nav-item dropdown">

		<a class="nav-link" data-toggle="dropdown" href="#">
			<i class="fa fa-bell-o"></i>
			<span class="badge badge-warning navbar-badge">{{notifications.length}}</span>
		</a>


		<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
			
			<span class="dropdown-item dropdown-header">{{notifications.length}} Notificações</span>
			
			<div class="dropdown-divider"></div>
			

    		<perfilAdicionadoNotification v-on:visualizado="loadNotifications(  )" v-for="notification in perfilAdicionado" :key="notification.id" :notification="notification">  
    		</perfilAdicionadoNotification>
 		
 			<perfilRemovidoNotification v-on:visualizado="loadNotifications(  )"  v-for="notification in perfilRemovido" :key="notification.id" :notification="notification">  
    		</perfilRemovidoNotification>
			 
			
			<div class="dropdown-divider"></div>
			<a   v-if="notifications.length > 0" href="#" class="dropdown-item dropdown-footer" v-on:click="limparNotifications">
				Limpar todas as Notificações
			</a>
		</div>
	</li>
	

	
 
</template>



<script>
	
	Vue.component('perfilAdicionadoNotification', require('./perfilAdicionadoNotification'));
	Vue.component('perfilRemovidoNotification', require('./perfilRemovidoNotification'));


	export default {

		props:[
			'usuario'
		],

		created(){
			this.loadNotifications();

			Echo.private( "App.User." + this.usuario.id )
				.notification((notification) => {
					this.loadNotifications(  );
					toastSucesso( notification.title , notification.message, function() {} , false );
					//console.log(notification.type);
					//console.log(notification); 
				});
		},


		computed:{
			perfilAdicionado:  function(){
				return this.notifications.filter(
					function( item ){
						return item.type.match('PerfilAdicionadoNotification');
					}
				)
			},

			perfilRemovido:  function(){
				return this.notifications.filter(
					function( item ){
						return item.type.match('PerfilRemovidoNotification');
					}
				)
			},

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

