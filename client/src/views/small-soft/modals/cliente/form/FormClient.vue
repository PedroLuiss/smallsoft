<script setup>
import { addUpdateClientes } from "@/action/cliente/clienteAction";
import { useClienteStore } from "@/store/clienteStore";
import { usePuntoVentaStore } from "@/store/puntoVentaStore";
import { ref } from 'vue';

const puntoVentaStore = usePuntoVentaStore();
const clienteStore = useClienteStore();

const editDialog = ref(false);
const textForm = ref("agregar");

const dataCliente = ref({
  id: null,
  nombre_completo: "",
  tipo_documento: null,
  numero_documento: "",
  email: "",
  direccion: "",
  telefono: "",
});


// status options
const selectedOptions = [
  {
    text: "CI",
    value: "CI",
  },
  {
    text: "EX",
    value: "EXT",
  }
];



const close = () => {
  if (Object.keys(clienteStore.selectClientEdit).length > 0) {
    console.log("Holaaaaaaaaaa");

    clienteStore.selectClientEdit = {};
  } else {
    clienteStore.modalClienteForm = false;
  }
  // editedIndex.value = -1;
  // editedItem.value = { ...defaultItem.value };
};


const save = async () => {


  console.log(dataCliente.value);
  const data = {
    id: dataCliente.value.id,
    nombre_apellido: dataCliente.value.nombre_completo,
    numero_documento: dataCliente.value.numero_documento,
    tipo_documento: dataCliente.value.tipo_documento,
    telefono: dataCliente.value.telefono,
    email: dataCliente.value.email,
    direccion: dataCliente.value.direccion,

  }

  try {
    const resp = await addUpdateClientes(data)
    console.log(resp);
    if (resp.return) {
      puntoVentaStore.TextsModalAlertVisible = true;
      puntoVentaStore.TextsModalAlert = resp.message;

      //refrescar lista cliente
      clienteStore.freshListCliente = true;

      dataCliente.value.nombre_completo = null
      dataCliente.value.numero_documento = null
      dataCliente.value.tipo_documento = null
      dataCliente.value.telefono = null
      dataCliente.value.email = null
      dataCliente.value.direccion = null
      clienteStore.modalClienteForm = false

    } else {
      let errorMessage = "";
      for (const field in resp.errors) {
        resp.errors[field].forEach(error => {
          errorMessage += `${field}: ${error}\n`;
        });
      }
      puntoVentaStore.TextsModalAlertVisible = true;
      puntoVentaStore.TextsModalAlert = errorMessage;
    }

  } catch (error) {
    //Manejar errores de la API que no son errores de validación. Por ejemplo:
    puntoVentaStore.TextsModalAlertVisible = true;
    puntoVentaStore.TextsModalAlert = "Ha ocurrido un error inesperado. Por favor, inténtelo de nuevo más tarde.";
    throw error;
  }

};

watch(
  () => [clienteStore.modalClienteForm],
  async ([value]) => {
    if (value) {
      console.log("Form mostrado");

    }
    editDialog.value = value;
  },
  { immediate: true }
);


// detectar si estan editando el cliente
watch(
  () => [clienteStore.selectClientEdit],
  async ([value]) => {
    if (Object.keys(value).length === 0) {

      clienteStore.modalClienteForm = false;
      textForm.value = "agregar";
    } else {
      textForm.value = "editar";
      clienteStore.modalClienteForm = true;
      console.log("cliente", value);

      dataCliente.value.id = value.id
      dataCliente.value.nombre_completo = value.nombre_apellido;
      dataCliente.value.tipo_documento = value.tipo_documento;
      dataCliente.value.numero_documento = value.numero_documento;
      dataCliente.value.email = value.email;
      dataCliente.value.direccion = value.direccion;
      dataCliente.value.telefono = value.telefono;


    }
  },
  { immediate: true }
);

</script>
<template>
  <!-- 👉 Edit Dialog  -->
  <VDialog v-model="editDialog" max-width="50%" persistent transition="dialog-top-transition">
    <VCard :title="`Formulario de ${textForm} cliente`">
      <VCardText>
        <!--<div class="text-body-1 mb-6">
          Name: <span class="text-h6">{{ editedItem?.fullName }}</span>
        </div>-->
        <VRow>
          <!-- fullName -->
          <VCol cols="12" sm="6">
            <AppTextField v-model="dataCliente.nombre_completo" density="compact" label="Nombre Completo" />
          </VCol>

          <VCol cols="12" sm="6">
            <AppSelect v-model="dataCliente.tipo_documento" density="compact" :items="selectedOptions" item-title="text"
              item-value="value" label="Tipo documento" />
          </VCol>

          <!-- age -->
          <VCol cols="12" sm="6">
            <AppTextField v-model="dataCliente.numero_documento" density="compact" label="Número de documento"
              type="number" />
          </VCol>

          <!-- email -->
          <VCol cols="12" sm="6">
            <AppTextField v-model="dataCliente.email" density="compact" label="Email" />
          </VCol>

          <!-- salary -->
          <VCol cols="12" sm="6">
            <AppTextField v-model="dataCliente.direccion" density="compact" label="Dirección" />
          </VCol>


          <VCol cols="12" sm="6">
            <AppTextField v-model="dataCliente.telefono" label="Teléfono" density="compact" type="number" />
          </VCol>


        </VRow>
      </VCardText>

      <VCardText>
        <div class="self-align-end d-flex gap-4 justify-end">
          <VBtn color="error" variant="outlined" @click="close">
            Cerrar
          </VBtn>
          <VBtn color="success" variant="elevated" @click="save">
            Guardar
          </VBtn>
        </div>
      </VCardText>
    </VCard>
  </VDialog>
</template>
