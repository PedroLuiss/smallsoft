
import { defineStore } from 'pinia';

export const useClienteStore = defineStore('clienteStore', {
  state: () => ({
   selectClientEdit: {},
   modalClienteForm: false,
   freshListCliente: false,

  }),
  actions: {
    async getProductoresGrup(suc_id, isLoading = true) {
     
    },
   

  }

});
