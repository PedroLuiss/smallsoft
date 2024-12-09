
import { defineStore } from 'pinia';

export const usePuntoVentaStore = defineStore('puntoVentaStore', {
  state: () => ({
    modalModuleCliente: false,
    modalModuleProducto: false,
    modalModuleInventario: false,
    modalModuleKardex: false,
    modalModuleCortes: false,
    modalModuleReportes: false,
    modalModuleAjustes:false

  }),
  actions: {
    async getProductoresGrup(suc_id, isLoading = true) {
     
    },
   

  }

});
