<script setup>
import { PerfectScrollbar } from "vue3-perfect-scrollbar";

const props = defineProps({
  isDrawerOpen: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(["update:isDrawerOpen", "userData"]);

const isFormValid = ref(false);
const refForm = ref();
const fullName = ref("");
const userName = ref("");
const email = ref("");
const company = ref("");
const country = ref();
const contact = ref("");
const role = ref();
const plan = ref();
const status = ref();

// 👉 drawer close
const closeNavigationDrawer = () => {
  emit("update:isDrawerOpen", false);
  nextTick(() => {
    refForm.value?.reset();
    refForm.value?.resetValidation();
  });
};

const onSubmit = () => {
  refForm.value?.validate().then(({ valid }) => {
    if (valid) {
      emit("userData", {
        id: 0,
        fullName: fullName.value,
        company: company.value,
        role: role.value,
        country: country.value,
        contact: contact.value,
        email: email.value,
        currentPlan: plan.value,
        status: status.value,
        avatar: "",
        billing: "Auto Debit",
      });
      emit("update:isDrawerOpen", false);
      nextTick(() => {
        refForm.value?.reset();
        refForm.value?.resetValidation();
      });
    }
  });
};

const handleDrawerModelValueUpdate = (val) => {
  emit("update:isDrawerOpen", val);
};

const currentTab = ref("item-1");
const tabItemContent =
  "Candy canes donut chupa chups candy canes lemon drops oat cake wafer. Cotton candy candy canes marzipan carrot cake. Sesame snaps lemon drops candy marzipan donut brownie tootsie roll. Icing croissant bonbon biscuit gummi bears. Pudding candy canes sugar plum cookie chocolate cake powder croissant.";
</script>

<template>
  <VCard class="ps-0 pr-0 pt-0" v-if="props.isDrawerOpen">
    <VRow>
      <VCol cols="12" md="3" class="d-flex flex-column">
        <!-- 👉 Form -->
        <VForm ref="refForm" v-model="isFormValid" @submit.prevent="onSubmit">
          <VRow>
            <!-- 👉 Full name -->
            <VCol cols="12">
              <AppTextField
                v-model="fullName"
                :rules="[requiredValidator]"
                label="Nombre completo"
                placeholder="Nombre Completo"
              />
            </VCol>

            <!-- 👉 Username -->
            <VCol cols="12">
              <AppTextField
                v-model="userName"
                :rules="[requiredValidator]"
                label="Usuario de acceso"
                placeholder="Usuario de acceso"
              />
            </VCol>
            <!-- 👉 Username -->
            <VCol cols="12">
              <AppTextField
                v-model="userName"
                :rules="[requiredValidator]"
                label="Contaseña"
                placeholder="Contraseña"
              />
            </VCol>

            <VCol cols="12">
              <AppTextField
                v-model="userName"
                :rules="[requiredValidator]"
                label="Confirmar Contraseña"
                placeholder="Contraseña"
              />
            </VCol>

            <!-- 👉 Email -->
            <VCol cols="12">
              <AppTextField
                v-model="email"
                :rules="[requiredValidator, emailValidator]"
                label="Correo Electrónico"
                placeholder="johndoe@email.com"
              />
            </VCol>

            <!-- 👉 Submit and Cancel -->
            <VCol cols="12">
              <VBtn type="submit" variant="tonal" color="success" class="me-4">
                Guradar
              </VBtn>
              <VBtn
                type="reset"
                variant="tonal"
                color="error"
                @click="closeNavigationDrawer"
              >
                Cancelar
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCol>
      <VCol cols="12" md="9" class="d-flex flex-column">
        <VCard class="pt-2">
          <VCardText class="pt-0">
            <h3 class="h3 mb-0 text-center w-100">Permisos del usuario</h3>
          </VCardText>
          <VDivider />
          <VTabs v-model="currentTab">
            <VTab>Ventas</VTab>
            <VTab>Clientes</VTab>
            <VTab>Productos</VTab>
            <VTab>Inventario</VTab>
            <VTab>Kardex</VTab>
            <VTab>Corte</VTab>
            <VTab>Reporte de ventas</VTab>
            <VTab>Usuarios</VTab>
            <VTab>Otros</VTab>
          </VTabs>

          <VCardText>
            <VWindow v-model="currentTab">
              <VWindowItem :value="0">
                <VCheckbox
                  label="Bloquear acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <VCheckbox
                  label="Permitir acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <div class="ms-4">
                  <VCheckbox
                    label="Registrar otro servicios"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Registrar Entradas"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Registrar Salida"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Ver el historial de ventas"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Permitir dar crédito"
                    color="secondary"
                    :value="color"
                  />
                </div>
              </VWindowItem>
              <VWindowItem :value="1">
                <VCheckbox
                  label="Bloquear acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <VCheckbox
                  label="Permitir acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <div class="ms-4">
                  <VCheckbox
                    label="Agregar Cliente"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Editar Clientes"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Desactivar Cliente"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Eliminar Cliente"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Registrar Abonos De Créditos"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Exportar a excel"
                    color="secondary"
                    :value="color"
                  />
                </div>
              </VWindowItem>
              <VWindowItem :value="2">
                <VCheckbox
                  label="Bloquear acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <VCheckbox
                  label="Permitir acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <div class="ms-4">
                  <VCheckbox
                    label="Visualizar Categoría"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Agregar una Categoria"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Editar Una Categoría"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Eliminar Una Categoría"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Agregar un producto"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Editar un producto"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Activar / Desactivar Un Producto"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Eliminar Un Producto"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Importar Producto"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Exportar a Excel"
                    color="secondary"
                    :value="color"
                  />
                </div>
              </VWindowItem>
              <VWindowItem :value="3">
                <VCheckbox
                  label="Bloquear acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <VCheckbox
                  label="Permitir acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <div class="ms-4">
                  <VCheckbox
                    label="Registrar Entradas"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Registrar Salida"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Registrar Ajustes"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Exportar a Excel"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Generar Código De Barras"
                    color="secondary"
                    :value="color"
                  />
                </div>
              </VWindowItem>
              <VWindowItem :value="4">
                <VCheckbox
                  label="Bloquear acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <VCheckbox
                  label="Permitir acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <div class="ms-4">
                  <VCheckbox
                    label="Agregar Cliente"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Editar Clientes"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Desactivar Cliente"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Eliminar Cliente"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Registrar Abonos De Créditos"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Exportar a excel"
                    color="secondary"
                    :value="color"
                  />
                </div>
              </VWindowItem>
              <VWindowItem :value="5">
                <VCheckbox
                  label="Bloquear acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <VCheckbox
                  label="Permitir acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <div class="ms-4">
                  <VCheckbox
                    label="Imprimir Corte"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Exportar Excel"
                    color="secondary"
                    :value="color"
                  />
                  
                </div>
              </VWindowItem>
              <VWindowItem :value="6">
                <VCheckbox
                  label="Bloquear acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <VCheckbox
                  label="Permitir acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <div class="ms-4">
                  <VCheckbox
                    label="Ver Reporte De Ventas"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Exportar Excel"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Ver Graficos De Ventas"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Ver Graficos De Productos Mas Vendidos"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Ver Gráfico De Categoria Mas Vendido"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Ver Tabla De Cliente Con MAs Compras"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Ver Tabla de horas con más Ventas"
                    color="secondary"
                    :value="color"
                  />
                </div>
              </VWindowItem>
              <VWindowItem :value="7">
                <VCheckbox
                  label="Bloquear acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <VCheckbox
                  label="Permitir acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <div class="ms-4">
                  <VCheckbox
                    label="Agregar Un Usuario"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Editar Un Usuario"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Desactivar Un Usuario"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Eliminar Un Usuario"
                    color="secondary"
                    :value="color"
                  />
                </div>
              </VWindowItem>
              <VWindowItem :value="8">
                <VCheckbox
                  label="Bloquear acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <VCheckbox
                  label="Permitir acceso a este módulo"
                  color="secondary"
                  :value="color"
                />
                <div class="ms-4">
                  <VCheckbox
                    label="Realizar Copias De Seguridad"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Restaurar Sistema"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Configurar Datos De Empresas"
                    color="secondary"
                    :value="color"
                  />
                  <VCheckbox
                    label="Configurar Impresora"
                    color="secondary"
                    :value="color"
                  />
                </div>
              </VWindowItem>
            </VWindow>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </VCard>
</template>
