<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";
import AjustesModuleModal from "@/views/small-soft/modals/ajustes/AjustesModuleModal.vue";
import ClientModuleModal from "@/views/small-soft/modals/cliente/ClientModuleModal.vue";
import CortesModuleModal from "@/views/small-soft/modals/cortes/CortesModuleModal.vue";
import HistorialVentasModal from "@/views/small-soft/modals/historial-ventas/HistorialVentasModal.vue";
import CalculadoraModal from "@/views/small-soft/modals/home/calculadora/CalculadoraModal.vue";
import BuscarClienteModal from "@/views/small-soft/modals/home/cliente/BuscarClienteModal.vue";
import EntradasVentasModal from "@/views/small-soft/modals/home/entradas/EntradasVentasModal.vue";
import OtrosServiciosModal from "@/views/small-soft/modals/home/otros-servicios/OtrosServiciosModal.vue";
import BuscarProductoModal from "@/views/small-soft/modals/home/producto/BuscarProductoModal.vue";
import SalidaVentasModal from "@/views/small-soft/modals/home/salida/SalidaVentasModal.vue";
import InventoryModuleModal from "@/views/small-soft/modals/inventario/InventoryModuleModal.vue";
import KardexModuleModal from "@/views/small-soft/modals/kardex/KardexModuleModal.vue";
import ProductModuleModal from "@/views/small-soft/modals/producto/ProductModuleModal.vue";
import ReportesModuleModal from "@/views/small-soft/modals/reportes/ReportesModuleModal.vue";
import { ref } from "vue";


definePage({
  meta: {
    layout: "blank",
    public: true,
  },
});

const form = ref({
  email: "",
  password: "",
  remember: false,
});

const states = [
  {
    name: 'Florida',
    abbr: 'FL',
    id: 1,
  },
  {
    name: 'Georgia',
    abbr: 'GA',
    id: 2,
  },
  {
    name: 'Nebraska',
    abbr: 'NE',
    id: 3,
  },
  {
    name: 'California',
    abbr: 'CA',
    id: 4,
  },
  {
    name: 'New York',
    abbr: 'NY',
    id: 5,
  },
]

function customFilter(itemTitle, queryText, item) {
  const textOne = item.raw.name.toLowerCase()
  const textTwo = item.raw.abbr.toLowerCase()
  const searchText = queryText.toLowerCase()

  return textOne.includes(searchText) || textTwo.includes(searchText)
}


const ClientGeneral = ref(false);

const puntoVentaStore = usePuntoVentaStore();

const purchasedProducts = [
  {
    name: 'Premium Branding Package',
    description: 'Branding & Promotion',
    qty: 1,
    hours: 15,
    price: 32,
  },
  {
    name: 'SMM',
    description: 'Social media templates',
    qty: 1,
    hours: 14,
    price: 28,
  },
  {
    name: 'Web Design',
    description: 'Web designing package',
    qty: 1,
    hours: 12,
    price: 24,
  },
  {
    name: 'SEO',
    description: 'Search engine optimization',
    qty: 1,
    hours: 5,
    price: 22,
  },
]

//-------------------------Abrir modales -------------------------
const modalCliente = () => {
  puntoVentaStore.modalModuleCliente = true
}

const modalProducto = () => {
  puntoVentaStore.modalModuleProducto = true
}

const modalInventario = () => {
  puntoVentaStore.modalModuleInventario = true
}

const modalKardex = () => {
  puntoVentaStore.modalModuleKardex = true
}

const modalCorte = () => {
  puntoVentaStore.modalModuleCortes = true
}

const modalReportes = () => {
  puntoVentaStore.modalModuleReportes = true
}


const modalAjustes = () => {
  puntoVentaStore.modalModuleAjustes = true
}

const modalOtrosServicio = () => {
  puntoVentaStore.modalOtrosServicios = true
}

const modalEntradasVentasClick = () => {
  puntoVentaStore.modalEntradasVentas = true
}
const modalSalidaVentasClick = () => {
  puntoVentaStore.modalSalidasVentas = true
}

const modalHistorialVentas = () => {
  puntoVentaStore.modalHistorialVentas = true
}

const modalBuscarProducto = () => {
  puntoVentaStore.modalBuscarProductos = true
}

const modalBuscarCliente = () => {

  puntoVentaStore.modalBuscarCLientes = true
}

const modalCalculadora = () => {
  puntoVentaStore.modalCalculadora = true
}
//-------------------------End Abrir modales -------------------------

const handlerCLientGeneral = () => {
  console.log(ClientGeneral.value);

}





const handleKeyPress = (event) => {
  console.log(event);

  if (event.keyCode === 112) { // El código para F1 es 112
    event.preventDefault(); // <--- Esta línea evita la acción por defecto
    modalCliente();
  }
};




watch(
  () => [puntoVentaStore.viewsModalAlert],
  async ([value]) => {
    if (value) {

    }

    puntoVentaStore.viewsModalAlert = false;
  },
  { immediate: true }
);

</script>

<template>
  <div class="ps-2 pe-2" @keydown="handleKeyPress">
    <VRow no-gutters class="mt-2 mb-2">
      <VCol cols="11">
        <VBtn @click="modalCliente" color="secondary" size="small">
          <VIcon start icon="bx-male" />Clientes [F1]
        </VBtn>
        <VBtn @click="modalProducto" color="secondary" class="ms-2" size="small">
          <VIcon start icon="bx-cabinet" />Productos [F2]
        </VBtn>
        <VBtn @click="modalInventario" color="secondary" class="ms-2" size="small">
          <VIcon start icon="bx-package" />Inventario [F3]
        </VBtn>
        <VBtn @click="modalKardex" color="secondary" class="ms-2" size="small">
          <VIcon start icon="bx-receipt" />Kardex [F4]
        </VBtn>
        <VBtn @click="modalCorte" color="secondary" class="ms-2" size="small">
          <VIcon start icon="bx-unlink" />Corte [F5]
        </VBtn>
        <VBtn @click="modalReportes" color="secondary" class="ms-2" size="small">
          <VIcon start icon="bx-money-withdraw" />Reportes [F6]
        </VBtn>
        <VBtn @click="modalAjustes" color="secondary" class="ms-2" size="small">
          <VIcon start icon="bx-credit-card-front" />Ajustes [F7]
        </VBtn>
      </VCol>
      <VCol cols="1" class="text-end">
        <RouterLink to="/">
          <VBtn color="info" size="small">
            <VIcon start icon="bx-arrow-back" />
            Salir
          </VBtn>
        </RouterLink>
      </VCol>
    </VRow>
    <VCard :loading="false" height="100%">
      <VCardText class="d-flex align-center flex-wrap text-body-1 pt-2 pb-2 px-3">
        <span>Serie: 15000 Numero: 15054151</span>
        <VDivider vertical class="mx-2" />
        <span class="d-flex align-center">¿Cliente General? [ALT+Q]
          <VSwitch v-model="ClientGeneral" @change="handlerCLientGeneral" class="ms-2" color="secondary" />
        </span>
        <VDivider vertical class="mx-2" />
        <span>Forma de pago [ALT+W]:</span>
        <div>
          <VBtn color="secondary" class="ms-2" size="small">
            Efectivo
            <VIcon end icon="bx-dollar-circle" />
          </VBtn>
          <VBtn color="secondary" class="ms-1" size="small">
            Crédito
            <VIcon end icon="bx-credit-card" />
          </VBtn>
          <VBtn color="secondary" class="ms-1" size="small">
            Mixto
            <VIcon end icon="bx-wallet-alt" />
          </VBtn>
        </div>
      </VCardText>
      <VCardText class="d-flex align-center flex-wrap text-body-1 pb-2 px-3">
        <div class="d-flex align-center">
          <span class="h4">Producto:</span>
          <AppTextField class="ms-2" width="350" density="compact" prepend-inner-icon="bx-barcode"
            placeholder="Código del producto + enter" />
        </div>

        <div class="ms-2">
          <VBtn @click="modalBuscarProducto" color="secondary" class="" size="small">
            <VIcon start icon="bx-search-alt-2" />Buscar Producto [ALT+L]
          </VBtn>
        </div>
        <VDivider vertical class="mx-2" />

        <div v-if="!ClientGeneral" class="d-flex align-center">
          <span class="h4">Cliente:</span>

          <AppAutocomplete width="350" class="ms-2" prepend-inner-icon="bx-universal-access" density="compact"
            :items="states" :custom-filter="customFilter" item-title="name" item-value="abbr"
            placeholder="Selecciona un cliente" />
        </div>

        <div v-if="!ClientGeneral" class="ms-2">
          <VBtn @click="modalBuscarCliente" color="secondary" class="" size="small">
            <VIcon start icon="bx-search-alt-2" />Buscar Cliente [ALT+E]
          </VBtn>
        </div>
      </VCardText>
      <VCardText class="d-flex align-center flex-wrap text-body-1 px-3">
        <div>
          <VBtn color="secondary" class="" size="small">
            <VIcon start icon="bx-plus-medical" /> NUEVO [ALT+A]
          </VBtn>
          <VBtn @click="modalOtrosServicio" color="secondary" class="ms-2" size="small">
            <VIcon start icon="bx-server" /> OTROS SERVICIOS [ALT+S]
          </VBtn>
          <VBtn @click="modalEntradasVentasClick" color="secondary" class="ms-2" size="small">
            <VIcon start icon="bx-basket" /> ENTRADAS [ALT+D]
          </VBtn>
          <VBtn @click="modalSalidaVentasClick" color="secondary" class="ms-2" size="small">
            <VIcon start icon="bx-spreadsheet" /> SALIDAS [ALT+F]
          </VBtn>
        </div>
        <VDivider vertical class="mx-2" />
        <div>
          <VBtn @click="modalCalculadora" size="small" icon="bx-calculator" rounded />
        </div>
      </VCardText>

      <!-- 👉 invoice Table -->
      <VTable class="invoice-preview-table border text-high-emphasis overflow-hidden mb-6 mx-3" hover="true"
        height="430" density="compact" fixed-header>
        <thead>
          <tr>
            <th scope="col" width="10%" class="bg-ligth">CÓDIGO</th>
            <th scope="col" width="30%" class="bg-ligth">DESCRIPCIÓN</th>
            <th scope="col" class="text-center bg-ligth" width="10%">CANTIDAD</th>
            <th scope="col" class="text-center bg-ligth" width="10%">P.VENTA</th>
            <th scope="col" class="text-center bg-ligth" width="10%">DESCUENTO</th>
            <th scope="col" class="text-center bg-ligth" width="10%">IMPORTE</th>
            <th scope="col" class="text-center bg-ligth" width="10%">DISPONIBLE</th>
            <th scope="col" class="text-center bg-ligth" width="10%"></th>
          </tr>
        </thead>

        <tbody class="text-base">
          <tr v-for="item in purchasedProducts" :key="item.name">
            <td class="text-no-wrap">
              {{ item.name }}
            </td>
            <td class="text-no-wrap">
              {{ item.description }}
            </td>
            <td class="text-center">
              {{ item.hours }}
            </td>
            <td class="text-center">
              {{ item.qty }}
            </td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
          </tr>
          <tr v-for="item in purchasedProducts" :key="item.name">
            <td class="text-no-wrap">
              {{ item.name }}
            </td>
            <td class="text-no-wrap">
              {{ item.description }}
            </td>
            <td class="text-center">
              {{ item.hours }}
            </td>
            <td class="text-center">
              {{ item.qty }}
            </td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
          </tr>
          <tr v-for="item in purchasedProducts" :key="item.name">
            <td class="text-no-wrap">
              {{ item.name }}
            </td>
            <td class="text-no-wrap">
              {{ item.description }}
            </td>
            <td class="text-center">
              {{ item.hours }}
            </td>
            <td class="text-center">
              {{ item.qty }}
            </td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
          </tr>
          <tr v-for="item in purchasedProducts" :key="item.name">
            <td class="text-no-wrap">
              {{ item.name }}
            </td>
            <td class="text-no-wrap">
              {{ item.description }}
            </td>
            <td class="text-center">
              {{ item.hours }}
            </td>
            <td class="text-center">
              {{ item.qty }}
            </td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
            <td class="text-center">${{ item.price }}</td>
          </tr>
        </tbody>
      </VTable>

      <!-- 👉 Total -->
      <div class="d-flex justify-space-between flex-column flex-sm-row print-row mx-2">
        <div class="mb-2 columnas_separadas_debajo">
          <VBtn @click="modalHistorialVentas" color="secondary" height="80%" class="ms-2">
            <VIcon start class="icon_btn_opt_rapido" icon="bx-history" />Historial De Ventas [ALt+Z]
          </VBtn>
          <VBtn color="secondary" height="80%" class="ms-2">
            <VIcon start class="icon_btn_opt_rapido" icon="bx-printer" />Reimprimir último ticket [ALt+O]
          </VBtn>
        </div>
        <div class="mb-2">
          <VBtn class="btn_cobros" color="secondary" size="x-large">
            <i class='bx bx-credit-card-front icon_btn_opt_rapido'></i><br>
            [ALT+C] <br>
            Cobro Normal
          </VBtn>
          <VBtn class="btn_cobros ms-5 text-center" color="secondary" size="x-large">
            <i class='bx bx-time-five icon_btn_opt_rapido'></i><br>
            [ALT+R] <br>
            Cobro Rápido
          </VBtn>
        </div>


        <div class="">
          <table class="w-100">
            <tbody class="text-body-1">
              <tr>
                <td class="pe-16">
                  <h3>Subtotal:</h3>
                </td>
                <td :class="$vuetify.locale.isRtl ? 'text-start' : 'text-end'">
                  <h6 class="text-h3">$1800</h6>
                </td>
              </tr>

              <tr>
                <td class="pe-16">
                  <h3>Impuesto:</h3>
                </td>
                <td :class="$vuetify.locale.isRtl ? 'text-start' : 'text-end'">
                  <h6 class="text-h3">21%</h6>
                </td>
              </tr>
            </tbody>
          </table>

          <VDivider class="my-2" />

          <table class="w-100">
            <tbody class="text-body-1">
              <tr>
                <td class="pe-16">
                  <h1>Total:</h1>
                </td>
                <td :class="$vuetify.locale.isRtl ? 'text-start' : 'text-end'">
                  <h6 class="text-h1">$1690</h6>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <VDivider class="mt-6 border-dashed" />

      <div class="footer-sof h-100 d-flex align-center justify-md-space-between justify-center">
        <!-- 👉 Footer: left content -->
        <span class="d-flex align-center d-inline-block text-body-1 text-medium-emphasis">
          &copy;
          {{ new Date().getFullYear() }}
          (v1.0.1) - Pedro Luis Rodriguez Rojas. Todos los derechos reservados, SmallSoft
          <VIcon icon="bx-bxs-heart" color="error" size="1.25rem" class="mx-1" />ft
          <a href="https://themeselection.com/" target="_blank" rel="noopener noreferrer"
            class="text-primary ms-1">Contactame</a>
        </span>
        <!-- 👉 Footer: right content -->
        <span class="d-md-flex gap-x-4 text-primary d-none">
          <p class="mb-0"><b>Hora:</b> 28/11/2024 15:23</p>
          <a href="https://themeselection.com/support/" target="noopener noreferrer" class="d-flex align-center"><i
              class='bx bx-help-circle'></i>Soporte</a>
        </span>
      </div>
    </VCard>

    <ClientModuleModal />
    <ProductModuleModal />
    <InventoryModuleModal />
    <KardexModuleModal />
    <CortesModuleModal />
    <AjustesModuleModal />
    <ReportesModuleModal />

    <OtrosServiciosModal />
    <EntradasVentasModal />
    <SalidaVentasModal />

    <HistorialVentasModal />

    <BuscarProductoModal />
    <BuscarClienteModal />
    <CalculadoraModal />

    <!-- Snackbar -->
    <VSnackbar v-model="puntoVentaStore.TextsModalAlertVisible">
      {{ puntoVentaStore.TextsModalAlert }}

      <template #actions>
        <VBtn color="error" @click="puntoVentaStore.TextsModalAlertVisible = false">
          X
        </VBtn>
      </template>
    </VSnackbar>

  </div>
</template>

<style lang="scss">
@use "@core/scss/template/pages/page-auth.scss";

.columnas_separadas_debajo {
  display: inline-grid;
  align-items: center;
}

.btn_cobros {
  block-size: 88% !important;
}

.btn_cobros {

  .v-btn__content,
  .v-btn__prepend,
  .v-btn__append {
    display: inline !important;
  }
}

.icon_btn_opt_rapido {
  font-size: 2vw;
}

.footer-sof {
  padding: 0.9vw;
}

.bg-ligth {
  background: #f7f7f7 !important;
}
</style>
