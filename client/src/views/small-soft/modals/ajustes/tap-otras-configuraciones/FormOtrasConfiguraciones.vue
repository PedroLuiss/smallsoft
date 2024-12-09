<script setup>
import { PerfectScrollbar } from "vue3-perfect-scrollbar";
import eCommerce2 from "@images/eCommerce/2.png";

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
  <VCard class="ps-0 pr-0 pt-0">
    <VCardText class="pt-0 pb-3">
      <h3 class="h3 mb-0 w-100">Otras Configuraciones</h3>
    </VCardText>
    <VRow>
      <VCol cols="12" md="6" class="d-flex flex-column">
        <VCard class="pt-2">
          <VCardText class="pt-0 pb-1">
            <h4 class="h3 mb-0 w-100">Configurar impresora</h4>
          </VCardText>
          <VDivider />
          <VRow>
            <VCol cols="12" md="12">
              <VRow no-gutters class="px-4 pb-6 pt-3">
                <VCol cols="12" md="6" class="mb-2 pr-1">
                  <AppTextField
                    label="Selecciones Impresora A4 [*]"
                    density="compact"
                    placeholder="Moneda"
                  />
                </VCol>
                <VCol cols="12" md="6" class="mb-2 ps-1">
                  <AppTextField
                    label="Selecciones impresora Ticket[*]"
                    density="compact"
                    placeholder="Letras"
                  />
                </VCol>
                <VCol cols="12" class="pt-3">
                  <VDivider />
                  <div class="mt-2 d-flex justify-center">
                    <div>
                      <p class="mb-0">Impresión Seleccionada</p>
                      <VRadioGroup inline>
                        <div>
                          <VRadio
                            label="Si"
                            color="Secondary"
                            value="1"
                            class="me-3"
                          />
                          <VRadio
                            label="No"
                            color="Secondary"
                            value="2"
                            class="me-3"
                          />
                        </div>
                      </VRadioGroup>
                    </div>
                  </div>
                  <VDivider />
                </VCol>
              </VRow>
            </VCol>
          </VRow>
        </VCard>
        <!-- 👉 Form -->
      </VCol>
      <VCol cols="12" md="6" class="d-flex flex-column">
        <VCard class="pt-2">
          <VCardText class="pt-0 pb-1">
            <h4 class="h3 mb-0 w-100">Configuración actual: Ticket</h4>
          </VCardText>
          <VDivider />
          <VRow>
            <VCol cols="12" md="12">
              <VRow no-gutters class="px-4 pb-6 pt-3">
                <VCol cols="12" md="6" class="mb-2 pr-1">
                  <AppTextField
                    label="Impresora Ticket"
                    density="compact"
                    placeholder="Moneda"
                  />
                </VCol>
                <VCol cols="12" md="6" class="mb-2 ps-1">
                  <AppTextField
                    label="Impresora A4"
                    density="compact"
                    placeholder="Letras"
                  />
                </VCol>
                
              </VRow>
            </VCol>
          </VRow>
        </VCard>
      </VCol>
      <VCol cols="12">
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
