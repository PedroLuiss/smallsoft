<script setup>
import { usePuntoVentaStore } from "@/store/puntoVentaStore";
import { ref } from 'vue'

const isModalOpen = ref(false)
const display = ref('0')
const currentValue = ref(null)
const operator = ref(null)
const waitingForOperand = ref(true)

const buttons = ['7', '8', '9', '÷', '4', '5', '6', '×', '1', '2', '3', '-', '0', '.', '=', '+', 'C', '%']

const isOperator = (btn) => ['÷', '×', '-', '+', '=', '%'].includes(btn)

const handleButtonClick = (btn) => {
  if (btn === 'C') {
    display.value = '0'
    currentValue.value = null
    operator.value = null
    waitingForOperand.value = true
  } else if (isOperator(btn)) {
    handleOperator(btn)
  } else {
    handleNumber(btn)
  }
}

const handleNumber = (num) => {
  if (waitingForOperand.value) {
    display.value = num
    waitingForOperand.value = false
  } else {
    display.value = display.value === '0' ? num : display.value + num
  }
}

const handleOperator = (op) => {
  const inputValue = parseFloat(display.value)
  
  if (currentValue.value == null) {
    currentValue.value = inputValue
  } else if (operator.value) {
    const result = calculate(currentValue.value, inputValue, operator.value)
    display.value = String(result)
    currentValue.value = result
  }

  waitingForOperand.value = true
  operator.value = op
}

const calculate = (a, b, op) => {
  switch(op) {
    case '+': return a + b
    case '-': return a - b
    case '×': return a * b
    case '÷': return a / b
    case '%': return (a * b) / 100
    default: return b
  }
}

const isDialogVisible = ref(false);
const firstName = ref("");
const middleName = ref("");
const lastName = ref("");
const email = ref("");
const password = ref("");
const age = ref();
const interest = ref([]);

const puntoVentaStore = usePuntoVentaStore();

watch(
  () => [puntoVentaStore.modalCalculadora],
  async ([value]) => {
    console.log(value);
    isDialogVisible.value = value;
  },
  { immediate: true }
);

watch(isDialogVisible, async (newValue) => {
  // console.log(newValue);
  if (!newValue) {
    puntoVentaStore.modalCalculadora = newValue;
  }
});
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="600" persistent>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

  <!-- Modal -->
  <transition name="modal">
      <div v-if="isDialogVisible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
          <!-- Cabecera del modal -->
          <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-xl font-bold text-gray-800">Calculadora</h2>
            <button @click="isDialogVisible = false" class="text-gray-600 hover:text-gray-800">
              x
            </button>
          </div>

          <!-- Contenido del modal (Calculadora) -->
          <div class="p-4">
            <!-- Pantalla de la calculadora -->
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
              <input
                type="text"
                v-model="display"
                readonly
                class="w-full text-right text-2xl font-bold bg-transparent outline-none"
              />
            </div>

            <!-- Botones de la calculadora -->
            <div class="grid grid-cols-4 gap-2">
              <button
                v-for="btn in buttons"
                :key="btn"
                @click="handleButtonClick(btn)"
                :class="[
                  'py-3 rounded-lg text-xl font-bold transition duration-200 ease-in-out transform hover:scale-105',
                  isOperator(btn) ? 'bg-orange-500 text-white hover:bg-orange-600' : 'bg-gray-200 text-gray-800 hover:bg-gray-300'
                ]"
              >
                {{ btn }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </VDialog>
</template>
<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>