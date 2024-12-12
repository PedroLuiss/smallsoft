<script setup>
import { usePuntoVentaStore } from '@/store/puntoVentaStore';

const isDialogVisible = ref(false)
const firstName = ref('')
const middleName = ref('')
const lastName = ref('')
const email = ref('')
const password = ref('')
const age = ref()
const interest = ref([]);

const puntoVentaStore = usePuntoVentaStore();

watch(
  () => [puntoVentaStore.modalOtrosServicios],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalOtrosServicios = newValue;
  }
});

</script>

<template>
  <VDialog
    v-model="isDialogVisible"
    max-width="600"
    persistent
  >
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn v-bind="props">
        Open Dialog
      </VBtn>
    </template>

    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

    <!-- Dialog Content -->
    <VCard title="Agregar otro producto o servicio no listado">
      <VCardText>
        <VRow>
          
          <VCol cols="12">
            <AppTextField
              v-model="password"
              label="Producto o servicio"
              type="text"
              placeholder="Ingrese el producto o servicio"
            />
          </VCol>
          <VCol
            cols="12"
            sm="6"
          >
            <AppTextField
              v-model="age"
              label="Ingrese la cantidad"
              type="number"
              placeholder="Ingrese la cantidad"
            />
          </VCol>
          <VCol
            cols="12"
            sm="6"
          >
            <AppTextField
              v-model="interest"
              label="Precio de ventas"
              placeholder="recio de ventas"
            />
          </VCol>
        </VRow>
      </VCardText>

      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn
          variant="tonal"
          color="secondary"
          @click="isDialogVisible = false"
        >
          Cerrar
        </VBtn>
        <VBtn @click="isDialogVisible = false">
          Guardar
        </VBtn>
      </VCardText>
    </VCard>
  </VDialog>
</template>
