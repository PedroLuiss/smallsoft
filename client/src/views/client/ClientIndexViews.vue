<template>
    <div class="py-4 container-fluid">
      
      <div class="row">
        <div class="col-12">
          <div class="card">
            
            <!-- Card header -->
            <div class="pb-0 card-header">
              <div class="d-lg-flex">
                <div>
                  <h5 class="mb-0">Lista De CLiente</h5>
                </div>
                <div class="my-auto mt-4 ms-auto mt-lg-0">
                  <div class="my-auto ms-auto">
                    <a @click="newClient" class="mb-0 btn bg-gradient-success btn-sm"
                      >+&nbsp; Nuevo Cliente</a
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="px-0 pb-0 card-body">
              <div class="table-responsive">
                <table id="users-list" ref="usersList" class="table table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Created At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="text-sm">
                    <tr v-for="client in clients" :key="client.id">
                      <td>{{client.name}}</td>
                      <td>{{client.correo}}</td>
                      <td>2023-01-16</td>
                      <td>
                        <a
                          @click="editClient(client)"
                          id="1"
                          class="actionButton cursor-pointer me-3"
                          data-bs-toggle="tooltip"
                          title="Editar CLiente"
                        >
                          <i class="fas fa-user-edit text-secondary"></i> </a
                        ><a
                          @click="alert"
                          id="2"
                          class="actionButton deleteButton cursor-pointer"
                          data-bs-toggle="tooltip"
                          title="Delete User"
                        >
                          <i class="fas fa-trash text-secondary"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div
              class="d-flex justify-content-center justify-content-sm-between flex-wrap"
              style="padding: 24px 24px 0px"
            >
              <div>
                <p>Showing 1 to 1 of 1 entries</p>
              </div>
              <ul class="pagination pagination-success pagination-md">
                <li class="page-item prev-page disabled">
                  <a class="page-link" aria-label="Previous">
                    <span aria-hidden="true"
                      ><i class="fa fa-angle-left" aria-hidden="true"></i
                    ></span>
                  </a>
                </li>
                <li class="page-item disabled active">
                  <a class="page-link" style="color: white">1</a>
                </li>
                <li class="page-item next-page disabled">
                  <a class="page-link" aria-label="Next">
                    <span aria-hidden="true"
                      ><i class="fa fa-angle-right" aria-hidden="true"></i
                    ></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </template>
  
  <script>
    import clientServices from "../../services/clientServices";
  
    export default {
    name: "Users",
    components: {
        //BasePagination,
    },
    data() {
        return {
        clients: []
        };
    },
    async mounted() {
        this.getClient(); // Llamar a la función para obtener los clientes al montar el componente
    },
    methods: {
        newClient() {
        console.log("Hola");
            this.$router.push({ name: 'ClienteCreate' });
        },
        async getClient() {
            try {
                this.clients = await clientServices.clientAll(); // Esperar a que se resuelva la promesa
                console.log("Clientes agregados");
                console.log(this.clients);
            } catch (error) {
                console.error("Error al obtener clientes:", error);
            }
        },
        editClient(cliente){
          console.log(cliente);
          this.$router.push({ 
            name: 'ClienteEdit',
            params: {id: cliente.id}
          });
          
        }
    }
    };
  </script>
  <style>
  td {
    padding: 12px 24px !important;
  }
  </style>
  
  