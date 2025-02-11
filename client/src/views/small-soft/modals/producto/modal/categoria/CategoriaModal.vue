<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";
import data from '@/views/demos/forms/tables/data-table/datatable';

const isDialogVisible = ref(false);
const puntoVentaStore = usePuntoVentaStore();


const userList = ref([])

const options = ref({
  page: 1,
  itemsPerPage: 10,
  sortBy: [''],
  sortDesc: [false],
})

// headers
const headers = [

  {
    title: 'Nombre Categoría',
    key: 'email',
  },

  {
    title: 'Accion',
    key: 'actions',
  },
]

const resolveStatusVariant = status => {
  if (status === 1)
    return {
      color: 'primary',
      text: 'Current',
    }
  else if (status === 2)
    return {
      color: 'success',
      text: 'Professional',
    }
  else if (status === 3)
    return {
      color: 'error',
      text: 'Rejected',
    }
  else if (status === 4)
    return {
      color: 'warning',
      text: 'Resigned',
    }
  else
    return {
      color: 'info',
      text: 'Applied',
    }
}

onMounted(() => {
  userList.value = JSON.parse(JSON.stringify(data))
})

//**********************************Tabla producto**********************************

watch(
  () => [puntoVentaStore.modalCategoriaViews],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalCategoriaViews = newValue;
  }
});

</script>

<template>
  <VDialog v-model="isDialogVisible" persistent max-width="1100">

    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />


    <!-- Dialog Content -->
    <VCard title="Gestión de categorias">
      <VRow>
        <VCol cols="12" md="7">
          <VDataTable :headers="headers" density="compact" :items="userList" :items-per-page="options.itemsPerPage"
            :page="options.page" :options="options">
            <!-- full name -->
            <template #item.fullName="{ item }">
              <div class="d-flex align-center">
                <VAvatar size="32" :color="item.avatar ? '' : 'primary'"
                  :class="item.avatar ? '' : 'v-avatar-light-bg primary--text'"
                  :variant="!item.avatar ? 'tonal' : undefined">
                  <VImg v-if="item.avatar" :src="item.avatar" />
                  <span v-else>{{ avatarText(item.fullName) }}</span>
                </VAvatar>
                <div class="d-flex flex-column ms-3">
                  <span class="d-block font-weight-medium text-high-emphasis text-truncate">{{ item.fullName }}</span>
                  <small>{{ item.post }}</small>
                </div>
              </div>
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
                  <VSelect v-model="options.itemsPerPage" :items="[10, 25, 50, 100]" label="Rows per page:"
                    variant="underlined" style="max-inline-size: 8rem;min-inline-size: 5rem;" />

                  <VPagination v-model="options.page" :total-visible="$vuetify.display.smAndDown ? 2 : 4"
                    :length="Math.ceil(userList.length / options.itemsPerPage)" />
                </div>
              </VCardText>
            </template>
          </VDataTable>
        </VCol>
        <VCol cols="12" md="5">
          <VCard title="Crear Nueva Categoría">
            <VCardText>
              <VRow>
                <VCol cols="12" sm="12" md="12">
                  <AppTextField v-model="firstName" label="Nombre de Categoría" placeholder="John" />
                </VCol>

              </VRow>
            </VCardText>


            <VCardText class="d-flex justify-end flex-wrap gap-3">
              <VBtn variant="tonal" color="secondary" @click="isDialogVisible = false">
                Cancelar
              </VBtn>
              <VBtn @click="isDialogVisible = false">
                Guardar
              </VBtn>
            </VCardText>
          </VCard>
        </VCol>
      </VRow>

    </VCard>

  </VDialog>
</template>
