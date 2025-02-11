
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
    modalSalidasVentas:false,
    modalHistorialVentas:false,
    modalBuscarProductos:false,
    modalBuscarCLientes:false,
    modalCalculadora:false,
    modalCategoriaViews:false,



    loaderMain:false,
    viewsModalAlert:false,
    TextsModalAlert:null,
    TextsModalAlertVisible:false

  }),
  actions: {
    async getProductoresGrup(suc_id, isLoading = true) {
     
    },
   

  }

});
