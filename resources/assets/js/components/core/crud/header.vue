<template>  
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">{{texto}}</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="/">Principal</a></li>
						<slot></slot>
					</ol>
				</div> 
			</div> 
		</div> 
	</div>

</template>

<script>

export default {

	props:[ 
		'texto'
	],  

}

</script>



<style>


</style>