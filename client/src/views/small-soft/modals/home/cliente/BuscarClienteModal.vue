<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";
import data from "@/views/demos/forms/tables/data-table/datatable";

const puntoVentaStore = usePuntoVentaStore();

const isDialogVisible = ref(false);
//------------------------------tabla-------------------------------
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

// status options
const selectedOptions = [
  {
    text: "Current",
    value: 1,
  },
  {
    text: "Professional",
    value: 2,
  },
  {
    text: "Rejected",
    value: 3,
  },
  {
    text: "Resigned",
    value: 4,
  },
  {
    text: "Applied",
    value: 5,
  },
];

// headers
const headers = [
  {
    title: "Nombre",
    key: "fullName",
  },
  {
    title: "Tipo Doc.",
    key: "email",
  },
  {
    title: "Numero Doc.",
    key: "startDate",
  },
  {
    title: "Email",
    key: "salary",
  },
  {
    title: "Dirección",
    key: "age",
  },
  {
    title: "Teléfono",
    key: "age",
  }
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

const editItem = (item) => {
  editedIndex.value = userList.value.indexOf(item);
  editedItem.value = { ...item };
  editDialog.value = true;
};

const addCliente = ()=>{
  editDialog.value = true;
}

const deleteItem = (item) => {
  editedIndex.value = userList.value.indexOf(item);
  editedItem.value = { ...item };
  deleteDialog.value = true;
};

const close = () => {
  editDialog.value = false;
  editedIndex.value = -1;
  editedItem.value = { ...defaultItem.value };
};

const closeDelete = () => {
  deleteDialog.value = false;
  editedIndex.value = -1;
  editedItem.value = { ...defaultItem.value };
};

const save = () => {
  if (editedIndex.value > -1)
    Object.assign(userList.value[editedIndex.value], editedItem.value);
  else userList.value.push(editedItem.value);
  close();
};

const deleteItemConfirm = () => {
  userList.value.splice(editedIndex.value, 1);
  closeDelete();
};

onMounted(() => {
  userList.value = JSON.parse(JSON.stringify(data));
});
// -----------------------------------------table-----------------------------------------

watch(
  () => [puntoVentaStore.modalBuscarCLientes],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalBuscarCLientes = newValue;
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
    <VCard title="Buscar clientes">
      <template #append>
        <VSpacer />
        <AppTextField
          width="700"
          color="dark"
          class="inut-fondo"
          prepend-inner-icon="bx-search-alt-2"
          placeholder="Buscar Cliente"
        />
      </template>
      <VCardText>
        <!-- 👉 Datatable  -->
        <VDataTable
          height="600"
          fixed-header
          hover="true"
          :headers="headers"
          :items="userList"
          :items-per-page="options.itemsPerPage"
          :page="options.page"
          :options="options"
        >
          <!-- full name -->
          <template #item.fullName="{ item }">
            <div class="d-flex align-center">
              <!-- avatar -->
              <VAvatar
                size="32"
                :color="item.avatar ? '' : 'primary'"
                :class="item.avatar ? '' : 'v-avatar-light-bg primary--text'"
                :variant="!item.avatar ? 'tonal' : undefined"
              >
                <VImg v-if="item.avatar" :src="item.avatar" />
                <span v-else>{{ avatarText(item.fullName) }}</span>
              </VAvatar>

              <div class="d-flex flex-column ms-3">
                <span
                  class="d-block font-weight-medium text-high-emphasis text-truncate"
                  >{{ item.fullName }}</span
                >
                <small>{{ item.post }}</small>
              </div>
            </div>
          </template>

          <!-- status -->
          <template #item.status="{ item }">
            <VChip
              :color="resolveStatusVariant(item.status).color"
              size="small"
            >
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
              <div
                class="d-flex flex-wrap justify-center justify-sm-space-between gap-y-2 mt-2"
              >
                <VSelect
                  v-model="options.itemsPerPage"
                  :items="[10, 20, 30, 50, 100]"
                  label="Rows per page:"
                  variant="underlined"
                  style="max-inline-size: 8rem; min-inline-size: 5rem"
                />

                <VPagination
                  v-model="options.page"
                  :total-visible="$vuetify.display.smAndDown ? 2 : 5"
                  :length="Math.ceil(userList.length / options.itemsPerPage)"
                />
              </div>
            </VCardText>
          </template>
        </VDataTable>
      </VCardText>
    </VCard>
  </VDialog>
</template>
