
import { defineStore } from 'pinia';

export const usePuntoVentaStore = defineStore('puntoVentaStore', {
  state: () => ({
    modalModuleCliente: false,
    modalModuleProducto: false,
    modalModuleInventario: false,
    modalModuleKardex: false,
    modalModuleCortes: false,
    modalModuleReportes: false,
    modalModuleAjustes:false,
    modalOtrosServicios:false,
    modalEntradasVentas:false,
    modalSalidasVentas:false

  }),
  actions: {
    async getProductoresGrup(suc_id, isLoading = true) {
     
    },
   

  }

});
