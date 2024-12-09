<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";
import ReportVentasAnualesMesDias from "./graficas/reportVentasAnualesMesDias.vue";
import ReportProductTop from "./graficas/ReportProductTop.vue";
import ReportCategoriTop from "./graficas/ReportCategoriTop.vue";
import ResportClientMasCompra from "./graficas/ResportClientMasCompra.vue";

const isDialogVisible = ref(false);
const puntoVentaStore = usePuntoVentaStore();

//**********************************Tabla producto**********************************

const editDialog = ref(false);
const deleteDialog = ref(false);

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [""],
  sortDesc: [false],
});

const headers = [
  {
    title: "Producto (Nombre, código)",
    key: "product",
  },
  {
    title: "Categoria",
    key: "category",
  },
  {
    title: "Stock",
    key: "stock",
    sortable: false,
  },
  {
    title: "P. Costo",
    key: "sku",
  },
  {
    title: "P. Venta",
    key: "price",
  },
  {
    title: "Mínimo",
    key: "qty",
  },
  {
    title: "Estado",
    key: "status",
  },
  {
    title: "Acciones",
    key: "actions",
    sortable: false,
  },
];

const selectedStatus = ref();
const selectedCategory = ref();
const selectedStock = ref();
const searchQuery = ref("");
const selectedRows = ref([]);

const status = ref([
  {
    title: "Scheduled",
    value: "Scheduled",
  },
  {
    title: "Publish",
    value: "Published",
  },
  {
    title: "Inactive",
    value: "Inactive",
  },
]);

const categories = ref([
  {
    title: "Accessories",
    value: "Accessories",
  },
  {
    title: "Home Decor",
    value: "Home Decor",
  },
  {
    title: "Electronics",
    value: "Electronics",
  },
  {
    title: "Shoes",
    value: "Shoes",
  },
  {
    title: "Office",
    value: "Office",
  },
  {
    title: "Games",
    value: "Games",
  },
]);

const stockStatus = ref([
  {
    title: "In Stock",
    value: true,
  },
  {
    title: "Out of Stock",
    value: false,
  },
]);

// Data table options
const itemsPerPage = ref(10);
const page = ref(1);
const sortBy = ref();
const orderBy = ref();

const updateOptions = (options) => {
  sortBy.value = options.sortBy[0]?.key;
  orderBy.value = options.sortBy[0]?.order;
};

const resolveCategory = (category) => {
  if (category === "Accessories")
    return {
      color: "error",
      icon: "bx-headphone",
    };
  if (category === "Home Decor")
    return {
      color: "info",
      icon: "bx-home-smile",
    };
  if (category === "Electronics")
    return {
      color: "primary",
      icon: "bx-laptop",
    };
  if (category === "Shoes")
    return {
      color: "success",
      icon: "bx-walk",
    };
  if (category === "Office")
    return {
      color: "warning",
      icon: "bx-briefcase",
    };
  if (category === "Games")
    return {
      color: "primary",
      icon: "bx-game",
    };
};

const resolveStatus = (statusMsg) => {
  if (statusMsg === "Scheduled")
    return {
      text: "Scheduled",
      color: "warning",
    };
  if (statusMsg === "Published")
    return {
      text: "Publish",
      color: "success",
    };
  if (statusMsg === "Inactive")
    return {
      text: "Inactive",
      color: "error",
    };
};

const { data: productsData, execute: fetchProducts } = await useApi(
  createUrl("/apps/ecommerce/products", {
    query: {
      q: searchQuery,
      stock: selectedStock,
      category: selectedCategory,
      status: selectedStatus,
      page,
      itemsPerPage,
      sortBy,
      orderBy,
    },
  })
);

const products = computed(() => productsData.value.products);
const totalProduct = computed(() => productsData.value.total);

const deleteProduct = async (id) => {
  await $api(`apps/ecommerce/products/${id}`, { method: "DELETE" });

  // Delete from selectedRows
  const index = selectedRows.value.findIndex((row) => row === id);
  if (index !== -1) selectedRows.value.splice(index, 1);

  // Refetch products
  fetchProducts();
};

const addCliente = () => {
  editDialog.value = true;
};

const close = () => {
  editDialog.value = false;
};

const closeDelete = () => {
  deleteDialog.value = false;
};

//**********************************Tabla producto**********************************

watch(
  () => [puntoVentaStore.modalModuleReportes],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalModuleReportes = newValue;
  }
});
</script>

<template>
  <VDialog
    v-model="isDialogVisible"
    fullscreen
    :scrim="false"
    transition="dialog-bottom-transition"
  >
    <!-- Dialog Content -->
    <VCard>
      <!-- Toolbar -->
      <div>
        <VToolbar color="secondary">
          <VToolbarItems>
            <VBtn variant="text">
              <VIcon start icon="bx-receipt" />
              Ver reportes de ventas
            </VBtn>
            <VBtn variant="text"> <VIcon start icon="bx-import" /></VBtn>
          </VToolbarItems>

          <VSpacer />

          <VBtn
            icon
            variant="plain"
            class="ms-5"
            @click="isDialogVisible = false"
          >
            <VIcon color="white" icon="bx-x" />
          </VBtn>
        </VToolbar>
      </div>
        <div class="d-flex align-center pt-2 pb-3">
          <div class="mr-2">
            <h4>Ventas de los últimos:</h4>
          </div>
          <div class="mr-2">
            <VBtn size="small" variant="outlined" color="secondary">
              30 dias
            </VBtn>
            <VBtn size="small" variant="outlined" color="secondary">
              90 dias
            </VBtn>
            <VBtn size="small" variant="outlined" color="secondary">
              180 dias
            </VBtn>
            <VBtn size="small" variant="outlined" color="secondary">
              365 dias
            </VBtn>
            <VBtn size="small" variant="outlined" color="secondary">
              Todos
            </VBtn>
            <VBtn size="small" variant="outlined" color="secondary">
              Desde el inicio del año
            </VBtn>
          </div>
          <AppDateTimePicker
            width="350"
            prepend-inner-icon="bx-time"
            prefix="$"
            class="inut-fondo"
            placeholder="Desde"
            density="compact"
          />
          <AppDateTimePicker
            width="350"
            prepend-inner-icon="bx-time"
            prefix="$"
            class="inut-fondo ms-3"
            placeholder="Hasta"
            density="compact"
          />
        </div>
      <VCardText class="pt-0">

        <ReportVentasAnualesMesDias/>
      <VRow class="mt-2">
        <VCol cols="12" md="6" >
          <ReportProductTop/>
        </VCol>
        <VCol cols="12" md="6" >
          <ReportCategoriTop/>
        </VCol>

        <VCol cols="12" md="6" >
          <ResportClientMasCompra/>
        </VCol>
      </VRow>


       
      </VCardText>
    </VCard>
  </VDialog>
</template>

<style lang="scss">
.dialog-bottom-transition-enter-active,
.dialog-bottom-transition-leave-active {
  transition: transform 0.2s ease-in-out;
}
.inut-fondo {
  background: aliceblue;
  border-radius: 6px;
}
</style>
