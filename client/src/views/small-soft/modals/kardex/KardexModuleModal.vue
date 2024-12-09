<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";

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
    title: "Fecha de Movimiento",
    key: "product",
  },
  {
    title: "Motivo",
    key: "category",
  },
  {
    title: "Tipo",
    key: "stock",
    sortable: false,
  },
  {
    title: "Cantidad",
    key: "sku",
  },
  {
    title: "Había",
    key: "price",
  },
  {
    title: "Hay",
    key: "qty",
  },
  {
    title: "Usuario",
    key: "status",
  },
  {
    title: "Producto",
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
  () => [puntoVentaStore.modalModuleKardex],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalModuleKardex = newValue;
  }
});
</script>

<template>
  <VDialog
    v-model="isDialogVisible"
    fullscreen
    transition="dialog-bottom-transition"
  >
    <!-- Dialog Content -->
    <VCard>
      <!-- Toolbar -->
      <div>
        <VToolbar color="secondary">
          <VToolbarItems>
            <VBtn @click="addCliente" variant="text">
              <VIcon start icon="bx-food-menu" />Kardex de producto
            </VBtn>
            
            <VBtn variant="text" @click="isDialogVisible = false">
              <VIcon start icon="bx-import" /> </VBtn
            >
            
          </VToolbarItems>

          <VSpacer />
          <AppDateTimePicker
          width="350"
           prepend-inner-icon="bx-time"
             prefix="$"
            class="inut-fondo"
            placeholder="Desde"
          />
          <AppDateTimePicker
          width="350"
           prepend-inner-icon="bx-time"
             prefix="$"
            class="inut-fondo ms-3"
            placeholder="Hasta"
          />
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
      <!-- 👉 products -->
      <!-- 👉 Datatable  -->
      <VDataTableServer
        :headers="headers"
        height="750"
        fixed-header
        hover="true"
        :items="products"
        class="text-no-wrap"
        @update:options="updateOptions"
        :items-per-page="options.itemsPerPage"
        :page="options.page"
        :options="options"
      >
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
              <span class="text-body-1 font-weight-medium text-high-emphasis">{{
                item.productName
              }}</span>
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
                  label="Tipo De Movimiento:"
                  variant="underlined"
                  style="max-inline-size: 8rem; min-inline-size: 5rem"
                />

                <VSelect
                  width="200"
                  class="ms-10"
                  v-model="options.itemsPerPage"
                  :items="[10, 20, 30, 50, 100]"
                  label="Usuario:"
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

      <!-- 👉 Edit Dialog  -->
      <VDialog v-model="editDialog" max-width="600px">
        <VCard title="Agregar Producto">
          <VCardText>
            <div class="text-body-1 mb-6">
              Name: <span class="text-h6">fffffffffffffff</span>
            </div>
            <VRow>
              <!-- fullName -->
              <VCol cols="12" sm="6">
                <AppTextField label="User name" />
              </VCol>

              <!-- email -->
              <VCol cols="12" sm="6">
                <AppTextField  label="Email" />
              </VCol>

              <!-- salary -->
              <VCol cols="12" sm="6">
                <AppTextField
                
                  label="Salary"
                  prefix="$"
                  type="number"
                />
              </VCol>

              <!-- age -->
              <VCol cols="12" sm="6">
                <AppTextField
                 
                  label="Age"
                  type="number"
                />
              </VCol>

              <!-- start date -->
              <VCol cols="12" sm="6">
                <AppTextField  label="Date" />
              </VCol>

              <!-- status -->
              <VCol cols="12" sm="6">
                <AppSelect
                 
                  item-title="text"
                  item-value="value"
                  label="Standard"
                />
              </VCol>
            </VRow>
          </VCardText>

          <VCardText>
            <div class="self-align-end d-flex gap-4 justify-end">
              <VBtn color="error" variant="outlined" @click="close">
                Cancel
              </VBtn>
              <VBtn color="success" variant="elevated" @click="save">
                Save
              </VBtn>
            </div>
          </VCardText>
        </VCard>
      </VDialog>

      <!-- 👉 Delete Dialog  -->
      <VDialog v-model="deleteDialog" max-width="500px">
        <VCard title="Are you sure you want to delete this item?">
          <VCardText>
            <div class="d-flex justify-center gap-4">
              <VBtn color="error" variant="outlined" @click="closeDelete">
                Cancel
              </VBtn>
              <VBtn
                color="success"
                variant="elevated"
                @click="deleteItemConfirm"
              >
                OK
              </VBtn>
            </div>
          </VCardText>
        </VCard>
      </VDialog>
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
