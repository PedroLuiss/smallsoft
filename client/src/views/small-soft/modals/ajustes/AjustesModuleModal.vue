<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";
import avatar1 from "@images/avatars/avatar-1.png";
import avatar2 from "@images/avatars/avatar-2.png";
import avatar3 from "@images/avatars/avatar-3.png";
import avatar5 from "@images/avatars/avatar-5.png";
import avatar8 from "@images/avatars/avatar-8.png";
import ListUser from "./tap-user/ListUser.vue";
import AddUser from "./tap-user/form/AddUser.vue";
import FormNegocio from "./tap-negocio/FormNegocio.vue";
import FormOtrasConfiguraciones from "./tap-otras-configuraciones/FormOtrasConfiguraciones.vue";

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

const moreList = [
  {
    title: "Share",
    value: "Share",
  },
  {
    title: "Refresh",
    value: "Refresh",
  },
  {
    title: "Update",
    value: "Update",
  },
];

const teamMembers = [
  {
    profilePic: avatar1,
    name: "Dean Hogan",
    designation: "IOS developer",
    project: "Zipper",
    projectIndication: "primary",
    task: "87/135",
    progress: 65,
  },
  {
    profilePic: avatar8,
    name: "Hilda Rice",
    designation: "Laravel developer",
    project: "Brandi",
    projectIndication: "success",
    task: "340/420",
    progress: 75,
  },
  {
    profilePic: avatar5,
    name: "Andrew O'Brien",
    designation: "React developer",
    project: "Payers",
    projectIndication: "warning",
    task: "50/82",
    progress: 55,
  },
  {
    profilePic: avatar2,
    name: "Eleanor Price",
    designation: "Angular developer",
    project: "Citibank",
    projectIndication: "error",
    task: "98/260",
    progress: 60,
  },
  {
    profilePic: avatar3,
    name: "Carl Oliver",
    designation: "VueJs developer",
    project: "Aviator",
    projectIndication: "secondary",
    task: "12/25",
    progress: 60,
  },
];

//**********************************Tabla producto**********************************
const currentTab = ref('window-1');

watch(
  () => [puntoVentaStore.modalModuleAjustes],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalModuleAjustes = newValue;
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
      <div class="">
        <VToolbar class="px-2" color="secondary">
          
          <VCardTitle class="text-white"
            >Ajustes del sistemas</VCardTitle
          >
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
      <div class="d-flex gap-6 ps-5 pr-5 pt-7 pb-6 h-100">
        <div>
          <VTabs v-model="currentTab" direction="vertical" class="v-tabs-pill">
            <VTab>
              <VIcon start icon="bx-user" />
              Usuarios
            </VTab>
            <VTab>
              <VIcon start icon="bx-store-alt" />
              Datos de negocios
            </VTab>

            <VTab>
              <VIcon start icon="bx-cog" />
              Otras Configuraciones
            </VTab>
            <VTab>
              <VIcon start icon="bx-reset" />
              Copias de seguridad
            </VTab>
          </VTabs>
        </div>

        <VCard width="100%">
          <VCardText>
            <VWindow v-model="currentTab">
              <VWindowItem value="window-1">
                <ListUser/>
                
              </VWindowItem>

              <VWindowItem value="window-2">
                <FormNegocio/>
              </VWindowItem>

              <VWindowItem value="window-3">
                <FormOtrasConfiguraciones/>
              </VWindowItem>
            </VWindow>
          </VCardText>
        </VCard>
      </div>
    
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
.bg-totales {
  background: #e3ff33;
}
</style>
