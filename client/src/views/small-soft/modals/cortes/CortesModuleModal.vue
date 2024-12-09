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
  () => [puntoVentaStore.modalModuleCortes],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalModuleCortes = newValue;
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
          <AppDateTimePicker
            width="250"
            prepend-inner-icon="bx-time"
            prefix="$"
            class="inut-fondo"
            placeholder="Desde"
          />
          <AppDateTimePicker
            width="250"
            prepend-inner-icon="bx-time"
            prefix="$"
            class="inut-fondo ms-3"
            placeholder="Hasta"
          />
          <VToolbarItems class="ms-4">
            <VBtn variant="text" @click="isDialogVisible = false">
              <VIcon start icon="bx-import" />
            </VBtn>
          </VToolbarItems>

          <VSpacer />

          <VBtn width="700" variant="outlined" color="success">
            <VIcon start icon="bx-printer" />Cerrar turno e imprimir
          </VBtn>
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
        <VCol cols="12" sm="6">
          <VCard>
            <!-- SECTION Card Header and Menu -->
            <VCardItem class="pb-1 pt-2">
              <!-- 👉 Title -->
              <VCardTitle>Listados De Cortes</VCardTitle>

              <!-- 👉 menu -->
              <template #append>
                <MoreBtn :menu-list="moreList" />
              </template>
            </VCardItem>
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
                    <th scope="col" class="border-0">Nº</th>
                    <th scope="col" class="border-0">Inicio</th>
                    <th scope="col" class="border-0">Fecha fin</th>
                    <th scope="col" class="border-0 ">Usuario</th>
                    <th scope="col" class="border-0 ">Estado</th>
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
                      <div class="d-flex align-center">
                        <VAvatar
                          size="28"
                          :image="member.profilePic"
                          class="me-3"
                        />

                        <div>
                          <h6 class="text-h6">
                            {{ member.name }}
                          </h6>
                          <span class="text-body-2 d-inline-block">{{
                            member.designation
                          }}</span>
                        </div>
                      </div>
                    </td>
                    <td class="border-0">
                      <VChip
                        label
                        size="small"
                        :color="member.projectIndication"
                        class="text-uppercase"
                      >
                        {{ member.project }}
                      </VChip>
                    </td>
                  </tr>
                </tbody>
              </VTable>
            </VCardText>
          </VCard>
        </VCol>
        <VCol cols="12" sm="6">
          <VCard class="ps-3 pr-3">
            <VCardText class="pb-2">
              Corte de <span><b>Pedro Luis Rodriguez Rojas</b></span>
            </VCardText>
            <VCardText>
              Corte Nº7 abierto por Pedro Luis Rodriguez Rojas (3/8/2023 15:02:46)
            </VCardText>
            <VRow > 
              <VCol cols="12" sm="6">
                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Ventas</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">Ventas Totales:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>

                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Dinero en caja</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">[+]Dinero inicial en caja:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>

                        <tr>
                          <td width="200px">[+]Ventas en efectivo:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">[+]Abonos de crédito:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">[+]Entradas de dinero:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">[-]Salida de dinero:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">[-]Devoluciones en efectivo:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr class="bg-totales">
                          <td width="200px">[=]Total en caja:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>

                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Ventas por categoria</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">[+]Dinero inicial en caja:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>

                        <tr>
                          <td width="200px">[+]Ventas en efectivo:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">[+]Abonos de crédito:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>

                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Anulaciones</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">[+]Dinero inicial en caja:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>

                        <tr>
                          <td width="200px">[+]Ventas en efectivo:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">[+]Abonos de crédito:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>

                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Impuestos</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">Impuestos cobrados:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>
               
              </VCol>
              <VCol cols="12" sm="6">
                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Ganancias</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">Ganancias con impuestos:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">Ganancias sin impuestos:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>

                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Resumen de ventas</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">[+]Ventas en efectivo:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>

                        <tr>
                          <td width="200px">[+]Ventas a crédito:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">[-]Devoluciones:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr class="bg-totales">
                          <td width="200px">[=]Total en caja:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>

                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Entradas de efectivo</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">Ganancias con impuestos:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">Ganancias sin impuestos:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>

                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Salidas de efectivo</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">Ganancias con impuestos:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">Ganancias sin impuestos:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>

                <VCard class="mb-4">
                  <VCardItem class="pt-2 pb-2">
                    <VCardTitle>Pagos de créditos</VCardTitle>
                  </VCardItem>

                  <VCardText>
                    <table width="100%" class="text-no-wrap" >
                      <tbody>
                        <tr>
                          <td width="200px">Ganancias con impuestos:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        <tr>
                          <td width="200px">Ganancias sin impuestos:</td>
                          <td class="font-weight-medium text-end">$2,093</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </VCardText>
                </VCard>
              </VCol>
            </VRow>
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
