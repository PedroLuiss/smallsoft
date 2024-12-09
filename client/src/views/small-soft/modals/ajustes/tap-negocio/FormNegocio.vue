<script setup>
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import eCommerce2 from '@images/eCommerce/2.png'

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
      nextTick(() => {
        refForm.value?.reset();
        refForm.value?.resetValidation();
      });
    }
  });
};

const currentTab = ref("item-1");
const tabItemContent =
  "Candy canes donut chupa chups candy canes lemon drops oat cake wafer. Cotton candy candy canes marzipan carrot cake. Sesame snaps lemon drops candy marzipan donut brownie tootsie roll. Icing croissant bonbon biscuit gummi bears. Pudding candy canes sugar plum cookie chocolate cake powder croissant.";
</script>

<template>
  <VCard
    class="ps-0 pr-0 pt-0"
  >
  <VCardText class="pt-0 pb-3">
    <p class="h3 mb-0 w-100">Configuración de datos de negocio - Los campos con [*] son obligatorios de llenar</p>
  </VCardText>
    <VRow>
      <VCol cols="12" md="8" class="d-flex flex-column">
        <VCard class="pt-2">
          <VCardText class="pt-0 pb-1">
            <h3 class="h3 mb-0 w-100">Datos del negocio</h3>
          </VCardText>
          <VDivider />
          <VRow>
            <VCol cols="12" md="6">
              <VRow no-gutters class="px-4 pb-6 pt-3">
                <VCol cols="12"  class="mb-2 pr-1">
                  <div class="pa-2 text-center d-flex justify-content-center">
                    <VImg
                      width="137"
                      height="176"
                      :src="eCommerce2"
                    />
                  </div>
                  <AppFileInput   density="compact" label="Imagen de la empresa" />
                </VCol>
                <VCol cols="12" md="6" class="mb-2 pr-1">
                  <AppTextField
                    label="Moneda [*]"
                    density="compact"
                    placeholder="Moneda"
                  />
                </VCol>
                <VCol cols="12" md="6" class="mb-2 ps-1">
                  <AppTextField
                    label="Letras [*]"
                    density="compact"
                    placeholder="Letras"
                  />
                </VCol>
                <VCol cols="12" md="6" class="pr-1">
                  <AppTextField
                    label="Tipo de identificador"
                    density="compact"
                    placeholder="Tipo de identificador"
                  />
                </VCol>
                <VCol cols="12" md="6" class="ps-1">
                  <AppTextField
                    label="Numero"
                    density="compact"
                    placeholder="Numero"
                  />
                </VCol>
              </VRow>
              
            </VCol>
            <VCol cols="12" md="6">
                <VRow no-gutters class="px-4 pb-6 pt-3">
                  <!-- 👉 Full name -->
                  <VCol cols="12" class="mb-2">
                    <AppTextField
                    class="mb-0"
                      v-model="fullName"
                      :rules="[requiredValidator]"
                      label="Nombre de empresa o negocio [*]"
                      placeholder="Nombre de empresa"
                        density="compact"
                    />
                  </VCol>

                  <!-- 👉 Username -->
                  <VCol cols="12" class="mb-2">
                    <AppTextField
                      v-model="userName"
                      :rules="[requiredValidator]"
                      label="Dirección de empresa o negocio"
                      placeholder="Dirección de empresa o negocio"
                        density="compact"
                    />
                  </VCol>
                  <!-- 👉 Username -->
                  <VCol cols="12" class="mb-2">
                    <AppTextField
                      v-model="userName"
                      :rules="[requiredValidator]"
                      label="Email de empresa"
                      placeholder="Email de empresa"
                        density="compact"
                    />
                  </VCol>

                  <VCol cols="12">
                    <AppTextField
                      v-model="userName"
                      :rules="[requiredValidator]"
                      label="Telefono de empresa"
                      placeholder="Telefono de empresa"
                        density="compact"
                    />
                  </VCol>
                </VRow>
            </VCol>
          </VRow>
        </VCard>
        <!-- 👉 Form -->
      </VCol>
      <VCol cols="12" md="4" class="d-flex flex-column">
        <VCard class="pt-2">
          <VCardText class="pt-0 pb-1">
            <h3 class="h3 mb-0 w-100">Impuestos</h3>
          </VCardText>
          <VDivider />

          <VCardText>
            <div class="">
              <p class="mb-0">Trabajas con impuesto? [*]</p>
              <VRadioGroup inline>
                <div>
                  <VRadio label="Si" color="Secondary" value="1" class="me-3" />
                  <VRadio label="No" color="Secondary" value="2" class="me-3" />
                </div>
              </VRadioGroup>
            </div>
            <div class="">
              <p class="mb-0">Los Precios incluyen impuestos? [*]</p>
              <VRadioGroup inline>
                <div>
                  <VRadio label="Si" color="Secondary" value="1" class="me-3" />
                  <VRadio label="No" color="Secondary" value="2" class="me-3" />
                </div>
              </VRadioGroup>
            </div>
            <div class="">
              <p class="mb-0">Nombre de impuesto:</p>
              <VRow>
                <VCol cols="12" md="6">
                  <AppTextField
                    label="Abrev."
                    density="compact"
                    placeholder="Ejemplo iva"
                  />
                </VCol>
                <VCol cols="12" md="6">
                  <AppTextField
                    label="%"
                    density="compact"
                    placeholder="Ejemplo iva"
                  />
                </VCol>
              </VRow>
            </div>
          </VCardText>
        </VCard>
      </VCol>
      <VCol cols="12" >
        <VBtn
        width="50%"
          type="submit"
          variant="tonal"
          color="success"
          class="me-4"
        >
          Editar datos y aplicar cambios
        </VBtn>
      </VCol>
    </VRow>
  
  </VCard>
</template>
