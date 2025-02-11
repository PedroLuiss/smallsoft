import { del, get, post, put } from "@/utils/sendApiNeo";


export const  getCajasData = async (id_suc, id_user_aut) => {
    try {
        return await get(`api/caja/get-caja/${id_suc}/${id_user_aut}`);

    } catch (error) {
        console.error(error);
        throw error; // Propaga el error para que se maneje en la llamada a la función
    }
};

export const addCajaListUser = async (data) => {
    try {
        return await post(`api/caja/list/add-caja`, data)

    } catch (error) {
        console.error(error);
        throw error;  
    }
};

export const CerrarCajaListUser = async (data) => {
    try {
        return await post(`api/caja/list/cerrar-caja`, data)

    } catch (error) {
        console.error(error);
        throw error;  
    }
};


export const  getMovimientosDisponibles = async (caja_id,filtro,suc_id) => {
    try {
        return await get(`api/caja/get-move-dispo/${caja_id}/${filtro}/${suc_id}`);

    } catch (error) {
        console.error(error);
        throw error; // Propaga el error para que se maneje en la llamada a la función
    }
};

export const  getMovimientosVentasTarjetaData = async (caja_id,suc_id) => {
    try {
        return await get(`api/caja/get-move-ventas-tarje/${caja_id}/${suc_id}`);

    } catch (error) {
        console.error(error);
        throw error; // Propaga el error para que se maneje en la llamada a la función
    }
};

export const  getUsuarioAsignadosData = async (caja_id,suc_id) => {
    try {
        return await get(`api/caja/administracion/get-user-asig/${caja_id}/${suc_id}`);

    } catch (error) {
        console.error(error);
        throw error; // Propaga el error para que se maneje en la llamada a la función
    }
};



export const addFilaUsuarioAsignado = async (data) => {
    try {
        return await post(`api/caja/administracion/add-user-asig`, data)

    } catch (error) {
        console.error(error);
        throw error;  
    }
};

export const updateFilaUsuarioAsignado = async (data) => {
    try {
        return await put(`api/caja/administracion/update-user-asig`, data)

    } catch (error) {
        console.error(error);
        throw error;  
    }
};

export const deleteFilaUsuarioAsignado = async (caja_id,suc_id,user_1) => {
    try {
        return await del(`api/caja/administracion/delete-user-asig?caja_id=${caja_id}&suc_id=${suc_id}&user_1=${user_1}`)

    } catch (error) {
        console.error(error);
        throw error;  
    }
};


export const  getMovimientoAgendadoCaja = async (caja_id,suc_id) => {
    try {
        return await get(`api/caja/administracion/get-mov-agendados/${caja_id}/${suc_id}`);

    } catch (error) {
        console.error(error);
        throw error; // Propaga el error para que se maneje en la llamada a la función
    }
};
