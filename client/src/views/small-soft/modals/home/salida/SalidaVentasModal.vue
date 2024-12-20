<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";

const isDialogVisible = ref(false);
const firstName = ref("");
const middleName = ref("");
const lastName = ref("");
const email = ref("");
const password = ref("");
const age = ref();
const interest = ref([]);

const puntoVentaStore = usePuntoVentaStore();


const desserts = [
  {
    dessert: 'Frozen Yogurt',
    calories: 159,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Ice cream sandwich',
    calories: 237,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Eclair',
    calories: 262,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Cupcake',
    calories: 305,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Gingerbread',
    calories: 356,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
]

watch(
  () => [puntoVentaStore.modalSalidasVentas],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalSalidasVentas = newValue;
  }
});
</script>

<template>
  <VDialog
    v-model="isDialogVisible"
    scrollable
    max-width="1100"
    content-class="scrollable-dialog"
    persistent
  >
    

    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

    <!-- Dialog Content -->
    <VCard title="Registro de salida de dinero">
      <VRow>
        <VCol cols="12" md="8" sm="6">
          <VTable  height="600" hover="true" density="compact" fixed-header class="text-no-wrap mt-5">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Acción</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="item in desserts" :key="item.dessert">
                <td>
                  {{ item.dessert }}
                </td>
                <td>
                  {{ item.calories }}
                </td>
                <td>
                  {{ item.fat }}
                </td>
                <td>
                  {{ item.carbs }}
                </td>
             
              </tr>
            </tbody>
          </VTable>
        </VCol>
        <VCol cols="12" md="4" sm="6">
          <VCardText class="mt-7">
            <VRow>
              <VCol cols="12">
                <h4 class="text-muted text-center">Detalle de la Salida</h4>
              </VCol>
              <VCol cols="12">
                <AppTextField
                  v-model="password"
                  label="Detalle de entrada"
                  type="text"
                  placeholder="Ingrese el detalle de entrada"
                  density="compact"
                />
              </VCol>

              <VCol cols="12">
                <AppTextField
                  v-model="amount"
                  label="Monto de Entrada"
                  prefix="$"
                  type="number"
                  density="compact"
                  placeholder="Ingrese el monto"
                />
              </VCol>
            </VRow>
            <VCardText class="d-flex justify-end flex-wrap gap-3">
              <VBtn
                variant="tonal"
                color="secondary"
                @click="isDialogVisible = false"
              >
                Cerrar
              </VBtn>
              <VBtn @click="isDialogVisible = false"> Guardar </VBtn>
            </VCardText>
          </VCardText>

          
        </VCol>
      </VRow>
    </VCard>
  </VDialog>
</template>
