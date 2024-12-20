<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";
import avatar1 from "@images/avatars/avatar-1.png";
import avatar2 from "@images/avatars/avatar-2.png";
import avatar3 from "@images/avatars/avatar-3.png";
import avatar5 from "@images/avatars/avatar-5.png";
import avatar8 from "@images/avatars/avatar-8.png";

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

watch(
  () => [puntoVentaStore.modalHistorialVentas],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalHistorialVentas = newValue;
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
            >Ver Ventas del actual corte</VCardTitle
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
      <VRow>
        <VCol cols="12" md="5">
          <VCard>
            
            <!-- !SECTION -->

            <VCardText class="px-1">
              <VTable
                hover="true"
                height="720"
                fixed-header
                density="compact"
                class="text-no-wrap"
              >
                <thead>
                  <tr class="text-uppercase">
                    <th scope="col" class="border-0">Serie</th>
                    <th scope="col" class="border-0">Numero</th>
                    <th scope="col" class="border-0">Fecha</th>
                    <th scope="col" class="border-0 ">Total</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="member in teamMembers" :key="member.name">
                    <td class="border-0">
                      <p class="mb-0">12</p>
                    </td>

                    <td class="border-0">
                      <span
                        class="text-body-1 d-inline-block font-weight-medium"
                        >{{ member.task }}</span
                      >
                    </td>

                    <td class="border-0">
                      <span
                        class="text-body-1 d-inline-block font-weight-medium"
                        >{{ member.task }}</span
                      >
                    </td>

                    <td class="border-0">
                      <span
                        class="text-body-1 d-inline-block font-weight-medium"
                        >{{ member.task }}</span
                      >
                    </td>
                    
                  </tr>
                </tbody>
              </VTable>
            </VCardText>
          </VCard>
        </VCol>
        <VCol cols="12" md="7">
          <VCard class="ps-3 pr-3">
            <VCardText class="pb-2">
              Tipo: <span><b>eess</b></span>
            </VCardText>
            <VCardText class="pb-2">
              Serie: <span><b>eess</b></span>
            </VCardText>
            <VCardText class="pb-2">
              Numero: <span><b>eess</b></span>
            </VCardText>
            <VCardText class="pb-2">
              Cajero: <span><b>eess</b></span>
            </VCardText>
            <VCardText class="pb-2">
              Cliente: <span><b>eess</b></span>
            </VCardText>
            <VCardText>
              Fecha de operación: (3/8/2023 15:02:46)
            </VCardText>
            <VCardText class="px-1">
              <VTable
                hover="true"
                height="380"
                fixed-header
                density="compact"
                class="text-no-wrap"
              >
                <thead>
                  <tr class="text-uppercase">
                    <th scope="col" class="border-0">Código</th>
                    <th scope="col" class="border-0">Descripción</th>
                    <th scope="col" class="border-0">cant.</th>
                    <th scope="col" class="border-0 ">Precio</th>
                    <th scope="col" class="border-0 ">Desc.</th>
                    <th scope="col" class="border-0 ">Impor.</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="member in teamMembers" :key="member.name">
                    <td class="border-0">
                      <p class="mb-0">12</p>
                    </td>

                    <td class="border-0">
                      <span
                        class="text-body-1 d-inline-block font-weight-medium"
                        >{{ member.task }}</span
                      >
                    </td>

                    <td class="border-0">
                      <span
                        class="text-body-1 d-inline-block font-weight-medium"
                        >{{ member.task }}</span
                      >
                    </td>

                    <td class="border-0">
                      <span
                        class="text-body-1 d-inline-block font-weight-medium"
                        >{{ member.task }}</span
                      >
                    </td>
                    <td class="border-0">
                      <span
                        class="text-body-1 d-inline-block font-weight-medium"
                        >{{ member.task }}</span
                      >
                    </td>
                    <td class="border-0">
                      <span
                        class="text-body-1 d-inline-block font-weight-medium"
                        >{{ member.task }}</span
                      >
                    </td>
                    
                  </tr>
                </tbody>
              </VTable>
            </VCardText>
            <VCardText class="px-1 d-flex justify-center">
              <div class="">
                <div class="d-flex text-center justify-center mb-2">
                  <div class="mx-1">
                    <p class="mb-0">Efectivo: <b>1000</b></p>
                  </div>
                  <div class="mx-1">
                    <p class="mb-0">Credito: <b>1000</b></p>
                  </div>
                </div>
                <div class="d-flex">
                  <div class="mx-1">
                    <p class="mb-0">SubTotal: <b>1000</b></p>
                  </div>
                  <div class="mx-1">
                    <p class="mb-0">Impuesto: <b>1000</b></p>
                  </div>
                  <div class="mx-1">
                    <p class="mb-0">Total: <b>1000</b></p>
                  </div>
                </div>
              </div>
            </VCardText>

            <VCardText class="px-1 d-flex " style="justify-content: space-between;">
              <div class=" d-flex justify-space-between" >
                <VBtn
                  color="error"
                  variant="tonal"
                >
                  Anular
                </VBtn>
              </div>
              <div class="">
                <VBtn
                  color="success"
                  variant="tonal"
                >
                  Imprimir
                </VBtn>
              </div>
            </VCardText>
          </VCard>
        </VCol>
      </VRow>
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
.bg-totales{
  background: #e3ff33;
}
</style>
