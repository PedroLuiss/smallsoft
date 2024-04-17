import axios from "axios";
import authHeader from "./auth-header";

const API_URL = process.env.VUE_APP_API_BASE_URL + '/';

export default {

  async clientAll() {
    const response =  await axios.get(API_URL + "cliente/list",{ headers: authHeader()});
    if (response.data) {
        return response.data            
    }
  },
  async register(client) {
    console.log("data");
    console.log(client);
    const response = await axios.post(API_URL + "clientes/store",client,{ headers: authHeader()});
    if (response.data) {
        return response.data
    }
  },
  async findClient(id_client) {
    console.log("edit peticion");
    console.log(id_client);
    const response = await axios.get(API_URL + "cliente/edit/"+id_client,{ headers: authHeader()});
    if (response.data) {
        // return response.data
        console.log(response.data);
    }
  }

};
