import { del, get, post } from "@/utils/sendApiNeo";


export const  getListCliente = async () => {
    try {
        return await get(`api/cliente/list`);

    } catch (error) {
        console.error(error);
        throw error; // Propaga el error para que se maneje en la llamada a la función
    }
};

export const addUpdateClientes = async (data) => {
    try {
        return await post(`api/clientes/store`, data)

    } catch (error) {
        console.error(error);
        throw error;  
    }
};

export const deleteCliente = async (id) => {
    try {
        return await del(`api/cliente/delet/${id}`)

    } catch (error) {
        console.error(error);
        throw error;  
    }
};
