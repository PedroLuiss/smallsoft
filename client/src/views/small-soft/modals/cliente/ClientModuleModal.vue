<script setup>
import { deleteCliente, getListCliente } from "@/action/cliente/clienteAction";
import { useClienteStore } from "@/store/clienteStore";
import { usePuntoVentaStore } from "@/store/puntoVentaStore";
import FormClient from "./form/FormClient.vue";

const isDialogVisible = ref(false);
const puntoVentaStore = usePuntoVentaStore();
const clienteStore = useClienteStore();

const editDialog = ref(false);
const deleteDialog = ref(false);

const defaultItem = ref({
  responsiveId: "",
  id: -1,
  avatar: "",
  fullName: "",
  post: "",
  email: "",
  city: "",
  startDate: "",
  salary: -1,
  age: "",
  experience: "",
  status: -1,
});

const editedItem = ref(defaultItem.value);
const editedIndex = ref(-1);
const userList = ref([]);

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [''],
  sortDesc: [false],
})

const search = ref('')

// headers
const headers = [
  {
    title: "Nombre",
    key: "nombre_apellido",
  },
  {
    title: "Tipo Doc.",
    key: "tipo_documento",
  },
  {
    title: "Numero Doc.",
    key: "numero_documento",
  },
  {
    title: "Email",
    key: "email",
  },
  {
    title: "Dirección",
    key: "direccion",
  },
  {
    title: "Teléfono",
    key: "telefono",
  },
  {
    title: "Deuda",
    key: "deuda",
  },
  {
    title: "Estado",
    key: "estado",
  },
  {
    title: "Acciones",
    key: "actions",
  },
];

const resolveStatusVariant = (status) => {
  if (status === 1)
    return {
      color: "primary",
      text: "Current",
    };
  else if (status === 2)
    return {
      color: "success",
      text: "Professional",
    };
  else if (status === 3)
    return {
      color: "error",
      text: "Rejected",
    };
  else if (status === 4)
    return {
      color: "warning",
      text: "Resigned",
    };
  else
    return {
      color: "info",
      text: "Applied",
    };
};


const getListClientes = async () => {
  try {
    puntoVentaStore.loaderMain = true;
    const { clientes } = await getListCliente();
    console.log(clientes);
    userList.value = clientes
    puntoVentaStore.loaderMain = false;
  } catch (error) {
    console.error(error);
    throw error; // Propaga el error para que se maneje en la llamada a la función
  }
}

const editItem = (item) => {
  clienteStore.selectClientEdit = item
};

const addCliente = () => {
  console.log("hola");
  clienteStore.modalClienteForm = true
}

const deleteItem = (item) => {
  console.log(item);

  editedIndex.value = userList.value.indexOf(item);
  editedItem.value = { ...item };
  deleteDialog.value = true;
};

const close = () => {
  editDialog.value = false;
  // editedIndex.value = -1;
  // editedItem.value = { ...defaultItem.value };
};

const closeDelete = () => {
  deleteDialog.value = false;
  // editedIndex.value = -1;
  // editedItem.value = { ...defaultItem.value };
};

// const save = () => {
//   if (editedIndex.value > -1)
//     Object.assign(userList.value[editedIndex.value], editedItem.value);
//   else userList.value.push(editedItem.value);
//   close();
// };

const deleteItemConfirm = async () => {
  userList.value.splice(editedIndex.value, 1);
  closeDelete();
  console.log(editedItem.value);
  const resp = await deleteCliente(editedItem.value.id)
  puntoVentaStore.TextsModalAlertVisible = true;
  puntoVentaStore.TextsModalAlert = resp.success;
  // clienteStore.freshListCliente = true;
};

onMounted(() => {
  // userList.value = JSON.parse(JSON.stringify(data));
});

watch(
  () => [puntoVentaStore.modalModuleCliente],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

//Refrescar el listado de clientes
watch(
  () => [clienteStore.freshListCliente],
  async ([value]) => {
    if (value) {
      await getListClientes();
    }
    clienteStore.freshListCliente = false;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  console.log(newValue);

  if (newValue) {
    await getListClientes();
  } else {
    puntoVentaStore.modalModuleCliente = newValue;
  }
});
</script>

<template>
  <VDialog v-model="isDialogVisible" fullscreen :scrim="false" transition="dialog-bottom-transition">
    <!-- Dialog Content -->
    <VCard>
      <!-- Toolbar -->
      <div>
        <VToolbar color="secondary">
          <VToolbarItems>
            <VBtn @click="addCliente" variant="text">
              <VIcon start icon="bx-male" />Agregar Cliente
            </VBtn>
            <VBtn variant="text" @click="isDialogVisible = false">
              <VIcon start icon="bx-import" />
            </VBtn>
          </VToolbarItems>
          <VCardTitle class="text-white">Deudas por cobrar:
            <span class="text-secundary">$ 12000</span>
          </VCardTitle>
          <VSpacer />
          <AppTextField color="white" class="inut-fondo" prepend-inner-icon="bx-search-alt-2"
            placeholder="Buscar Cliente" v-model="search" />
          <VBtn icon variant="plain" class="ms-5" @click="isDialogVisible = false">
            <VIcon color="white" icon="bx-x" />
          </VBtn>
        </VToolbar>
      </div>
      <!-- 👉 Datatable  -->
      <VDataTable height="750" :search="search" :loading="puntoVentaStore.loaderMain" fixed-header :hover="true"
        :headers="headers" :items="userList" :items-per-page="options.itemsPerPage" :page="options.page"
        :options="options">
        <!-- full name -->
        <template #item.nombre_apellido="{ item }">
          <div class="d-flex align-center">
            <!-- avatar -->
            <VAvatar size="32" :color="item.avatar ? '' : 'primary'"
              :class="item.avatar ? '' : 'v-avatar-light-bg primary--text'"
              :variant="!item.avatar ? 'tonal' : undefined">
              <VImg v-if="item.avatar" :src="item.avatar" />
              <span v-else>{{ avatarText(item.nombre_apellido) }}</span>
            </VAvatar>

            <div class="d-flex flex-column ms-3">
              <span class="d-block font-weight-medium text-high-emphasis text-truncate">{{ item.nombre_apellido
                }}</span>
              <small>{{ item.email }}</small>
            </div>
          </div>
        </template>

        <!-- status -->
        <template #item.status="{ item }">
          <VChip :color="resolveStatusVariant(item.status).color" size="small">
            {{ resolveStatusVariant(item.status).text }}
          </VChip>
        </template>

        <!-- Actions -->
        <template #item.actions="{ item }">
          <div class="d-flex gap-1">
            <IconBtn @click="editItem(item)">
              <VIcon icon="bx-edit" />
            </IconBtn>
            <IconBtn @click="deleteItem(item)">
              <VIcon icon="bx-trash" />
            </IconBtn>
          </div>
        </template>
        <template #bottom>
          <VCardText class="pt-2">
            <div class="d-flex flex-wrap justify-center justify-sm-space-between gap-y-2 mt-2">
              <VSelect v-model="options.itemsPerPage" :items="[10, 20, 30, 50, 100]" label="Rows per page:"
                variant="underlined" style="max-inline-size: 8rem;min-inline-size: 5rem;" />

              <VPagination v-model="options.page" :total-visible="$vuetify.display.smAndDown ? 2 : 5"
                :length="Math.ceil(userList.length / options.itemsPerPage)" />
            </div>
          </VCardText>
        </template>
      </VDataTable>

      <FormClient />

      <!-- 👉 Delete Dialog  -->
      <VDialog v-model="deleteDialog" max-width="500px">
        <VCard title="Are you sure you want to delete this item?">
          <VCardText>
            <div class="d-flex justify-center gap-4">
              <VBtn color="error" variant="outlined" @click="closeDelete">
                Cancel
              </VBtn>
              <VBtn color="success" variant="elevated" @click="deleteItemConfirm">
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
  border-radius: 6px;
  background: aliceblue;
}
</style>
