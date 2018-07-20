<template>
  <form action="#" @submit.prevent="AdicionarPermissao" @keydown="form.errors.clear($event.target.name)">
    <crudCard>
      <div class="card-body">
        <crudFormElemento :errors="form.errors.has('permissao')" :errors_texto="form.errors.get('permissao')">
          <label for="descricao">Permissão:</label>
          <select2 v-model="form.permissao" class="form-control" v-bind:class="{ 'is-invalid': form.errors.has('permissao') }">
            <option value=""> Selecione a permissão </option>
            <option v-for="p in permissoes" :key="p.id" :value="p.id"> {{p.nome}} </option>
          </select2>
        </crudFormElemento>
      </div>
      <div class="card-footer text-right">
        <crudBotaoSalvar :disabled="form.errors.any()" texto="Adicionar"/>
      </div>
    </crudCard>
  </form>
</template>


<script>

import Form from "../../core/Form";

export default {
  
  props: ["url", "permissoes"],

  data() {
    return {
      form: new Form({
        permissao: ""
      })
    };
  },



  methods: {
    
    AdicionarPermissao() {
        if (this.form.permissao) {
          this.form.submit("post", this.url + "/" + this.$route.params.id + "/adicionar/permissao")
            .then(response => { 
              toastSucesso("permissao adicionado co successo."); 
              this.$emit('permissaoAdicionada', response ) 
            })
            .catch(errors => console.log(errors));
        }
    },

     
  }
};
</script>
 
<style scoped>
</style>