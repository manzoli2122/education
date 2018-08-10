<template>  
	<div>  
		<crudHeader texto="Meu perfil">
			<li class="breadcrumb-item">Meu perfil</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle"
							src="/img/avatar.png"
							alt="User profile picture">
						</div>

						<h3 class="profile-username text-center">{{user.name}}</h3>

						<p class="text-muted text-center">{{user.post_grad_dsc}}</p>

						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
								<b>Email</b> <a class="float-right">{{user.email}}</a>
							</li>
							<li class="list-group-item">
								<b>RG</b> <a class="float-right">{{user.rg}}</a>
							</li>
							<li class="list-group-item">
								<b>NF</b> <a class="float-right">{{user.nf}}</a>
							</li>
							<li class="list-group-item">
								<b>Quadro</b> <a class="float-right">{{user.quadro_dsc}}</a>
							</li>
							<li class="list-group-item">
								<b>OME</b> <a class="float-right">{{user.ome_qdi_dsc}}</a>
							</li>
							<li class="list-group-item">
								<b>Setor</b> <a class="float-right">{{user.setor_qdi_dsc}}</a>
							</li>
							
						</ul>

						<a href="#" class="btn btn-primary btn-block"><b>Atualizar dados no RH</b></a>

						<router-link to="/notificacoes" exact class="btn btn-primary btn-block"><a>Notificações</a></router-link>
					</div>

				</crudCard> 
			</div> 
		</div>  
	</div>
</template>

<script>

	export default {

		props:[
		'url' , 'user'
		],  

		data() {
			return {                
				 
			}
		},

	}

</script>

<style > 
 
</style>