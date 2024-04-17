<template>
    <div class="py-4 container-fluid">
      
      <div class="row">
        <div class="col-12">
          <div class="card">
            
            <!-- Card header -->
            <div class="pb-0 card-header">
              <div class="d-lg-flex">
                <div>
                  <h5 class="mb-0">Crear Nuevo Cliente</h5>
                </div>
              </div>
            </div>
            <div class="px-5 pb-0 card-body">
                <form action="" class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="" v-model="client.name" placeholder="Ingrese el nombre">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Identificación</label>
                            <input type="text" class="form-control" id="" v-model="client.identificacion" placeholder="Identificación">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="" v-model="client.telefono" placeholder="Teléfono">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Persona</label>
                            <input type="text" class="form-control" id="" v-model="client.person_contact" placeholder="Persona">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="" v-model="client.correo" placeholder="Correo">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Pais</label>
                            <select class="form-select"  v-model="client.pais"  aria-label="Default select example">
                                <option v-for="pai in pais" :key="pai.id" :value="pai.country_name">{{pai.country_name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Información importante del cliente</label>
                            <input type="text" class="form-control" id="" v-model="client.otros" placeholder="Información importante del cliente">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                        <label for="" class="form-label">Dirección</label>
                        <textarea class="form-control"  v-model="client.direccion" id="" rows="3" placeholder="Dirección"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                        <label for="" class="form-label">Regimen/Obligación</label>
                        <textarea class="form-control"  v-model="client.regimen" id="" rows="3" placeholder="Regimen/Obligación"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer px-5 pb-4 mb-4">
                <div class="my-auto ms-auto">
                <a @click="saveCliente" class="mb-0 btn bg-gradient-success "
                    >Guardar</a
                >
                <a @click="listClient" class="ms-3 mb-0 btn bg-gradient-dark "
                    >Cancelar</a
                >
                </div>
            </div>

          </div>
        </div>
      </div>
      
    </div>
  </template>
  
  <script>
    import paiseService from "../../services/paiseService";
    import clientServices from "../../services/clientServices";
    import showSwal from "/src/mixins/showSwal.js";
  
    export default {
    name: "Users",
    components: {
        //BasePagination,
    },
    data() {
        return {
            client: {
                name:"",
                correo:"",
                identificacion:"",
                telefono: "",
                person_contact: "",
                pais:"",
                otros:"",
                direccion:"",
                regimen:""
            },
            pais:[]
        };
    },
    async mounted() {
       
    },
    async beforeMount(){
        this.getPais();
    },
    methods: {
        listClient() {
            this.$router.push({ name: 'Cliente' });
        },
        async saveCliente(){
            console.log("Save cliente");
            console.log(this.client);

            try {
                await clientServices.register(this.client);
                showSwal.methods.showSwal({
                    type: "success",
                    message:
                    "Cliente creado correctamente.",
                    width: 600,
                });
            } catch (error) {
                showSwal.methods.showSwal({
                    type: "error",
                    message: "Error al crear el cliente.",
                    width: 500,
                });
            }
        },
        async getPais() {
            try {
                this.pais = await  paiseService.getPaises();
                console.log(this.pais);
            } catch (error) {
                console.error("Error al obtener clientes:", error);
            }
        }
    }
    };
  </script>
  <style>
  td {
    padding: 12px 24px !important;
  }
  </style>
  