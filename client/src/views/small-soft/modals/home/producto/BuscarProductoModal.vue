<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";


const puntoVentaStore = usePuntoVentaStore();

const isDialogVisible = ref(false);
//------------------------------tabla-------------------------------
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
    title: "Código",
    key: "sku",
  },
  {
    title: "Producto (Nombre, Descripción)",
    key: "product",
  },
  {
    title: "Categoria",
    key: "category",
  },
  {
    title: "Stock",
    key: "price",
    sortable: false,
  },

  {
    title: "P. Venta",
    key: "price",
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

// -----------------------------------------table-----------------------------------------

watch(
  () => [puntoVentaStore.modalBuscarProductos],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalBuscarProductos = newValue;
  }
});
</script>

<template>
  <VDialog
    v-model="isDialogVisible"
    scrollable
    max-width="95vw"
    max-height="100%"
    content-class="scrollable-dialog"
    persistent
  >
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

    <!-- Dialog Content -->
    <VCard title="Buscar producto en ventas" >
      <template #append>
        <VSpacer />
        <AppTextField
          width="700"
          color="dark"
          class="inut-fondo"
          prepend-inner-icon="bx-search-alt-2"
          placeholder="Buscar Producto"
        />
      </template>
      <VCardText>
        <!-- 👉 Datatable  -->
        <VDataTableServer
          :headers="headers"
          height="600"
          fixed-header
          hover="true"
          :items="products"
          class="text-no-wrap"
          @update:options="updateOptions"
          :items-per-page="options.itemsPerPage"
          :page="options.page"
          :options="options"
        >

        <!-- category -->
        <template #item.sku="{ item }">
            
            <span class="text-body-1  text-high-emphasis">
              <b>{{ item.sku }}</b>
            </span>
          </template>
          <!-- product  -->
          <template #item.product="{ item }">
            <div class="d-flex align-center gap-x-4">
              <VAvatar
                v-if="item.image"
                size="38"
                variant="tonal"
                rounded
                :image="item.image"
              />
              <div class="d-flex flex-column">
                <span
                  class="text-body-1 font-weight-medium text-high-emphasis"
                  >{{ item.productName }}</span
                >
                <span class="text-body-2">{{ item.productBrand }}</span>
              </div>
            </div>
          </template>

          <!-- category -->
          <template #item.category="{ item }">
            <VAvatar
              size="30"
              variant="tonal"
              :color="resolveCategory(item.category)?.color"
              class="me-4"
            >
              <VIcon :icon="resolveCategory(item.category)?.icon" size="18" />
            </VAvatar>
            <span class="text-body-1 text-high-emphasis">{{
              item.category
            }}</span>
          </template>

          <!-- stock -->
          <template #item.stock="{ item }">
            <VSwitch :model-value="item.stock" />
          </template>

          <!-- status -->
          <template #item.status="{ item }">
            <VChip
              v-bind="resolveStatus(item.status)"
              density="default"
              label
              size="small"
            />
          </template>

          <!-- Actions -->
          <template #item.actions="{ item }">
            <IconBtn>
              <VIcon icon="bx-edit" />
            </IconBtn>

            <IconBtn>
              <VIcon icon="bx-dots-vertical-rounded" />
              <VMenu activator="parent">
                <VList>
                  <VListItem value="download" prepend-icon="bx-download">
                    Download
                  </VListItem>

                  <VListItem
                    value="delete"
                    prepend-icon="bx-trash"
                    @click="deleteProduct(item.id)"
                  >
                    Delete
                  </VListItem>

                  <VListItem value="duplicate" prepend-icon="bx-copy">
                    Duplicate
                  </VListItem>
                </VList>
              </VMenu>
            </IconBtn>
          </template>

          <!-- pagination -->
          <template #bottom>
            <VCardText class="pt-2">
              <div
                class="d-flex flex-wrap justify-center justify-sm-space-between gap-y-2 mt-2"
              >
                <div class="d-flex">
                  <VSelect
                    width="300"
                    v-model="options.itemsPerPage"
                    :items="[10, 20, 30, 50, 100]"
                    label="Filas por páginas:"
                    variant="underlined"
                    style="max-inline-size: 8rem; min-inline-size: 5rem"
                  />
                  <VSelect
                    width="200"
                    class="ms-10"
                    v-model="options.itemsPerPage"
                    :items="[10, 20, 30, 50, 100]"
                    label="Categorias:"
                    variant="underlined"
                    style="max-inline-size: 8rem; min-inline-size: 5rem"
                  />

                  
                </div>

                <VPagination
                  v-model="options.page"
                  :total-visible="$vuetify.display.smAndDown ? 2 : 5"
                  :length="Math.ceil(totalProduct / options.itemsPerPage)"
                />
              </div>
            </VCardText>
          </template>
        </VDataTableServer>
      </VCardText>
    </VCard>
  </VDialog>
</template>
