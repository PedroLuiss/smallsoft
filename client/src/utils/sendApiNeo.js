// // api.js

// const apiUrl = import.meta.env.API_BASE_URL || 'http://127.0.0.1:8000'; // Reemplaza con la URL base de tu API

// async function apiRequest(method, endpoint, data = null) {
//   try {
//     const headers = {
//       'Content-Type': 'application/json',
//       'Accept': 'application/json',
//       // Agrega aquí encabezados adicionales si los necesitas (por ejemplo, Authorization)
//     };

//     const response = await fetch(`${apiUrl}/${endpoint}`, {
//       method: method,
//       headers: headers,
//       body: data ? JSON.stringify(data) : null,
//     });

//     if (!response.ok) {
//       // Manejar errores, por ejemplo, mostrar un mensaje al usuario
//       throw new Error('Error en la petición');
//     }

//     const json = await response.json();
//     return json;
//   } catch (error) {
//     // Manejar errores, por ejemplo, mostrar un mensaje al usuario
//     console.error('Error en la petición:', error);
//     throw error;
//   }
// }

// // Funciones para cada tipo de petición
// export const get = async (endpoint) => {
//   return await apiRequest('GET', endpoint);
// };

// export const post = async (endpoint, data) => {
//   return await apiRequest('POST', endpoint, data);
// };

// export const put = async (endpoint, data) => {
//   return await apiRequest('PUT', endpoint, data);
// };

// export const del = async (endpoint) => {
//   return await apiRequest('DELETE', endpoint);
// };

// Ejemplo de uso:
// get('/users')
//   .then(data => console.log(data))
//   .catch(error => console.error(error));

// Variable global para la URL base de la API https://mssql.neo.do
const apiUrl = import.meta.env.API_BASE_URL || "http://127.0.0.1:8000"; // Reemplaza con la URL base de tu API

// Función para realizar peticiones a la API
async function apiRequest(method, endpoint, data = null) {
  const accessToken = useCookie("accessToken").value;
  try {
    // Encabezados de la petición
    // console.log("accessToken",accessToken);
    const headers = {
      "Content-Type": "application/json",
      Accept: "application/json",
      // Agrega aquí encabezados adicionales si los necesitas (por ejemplo, Authorization)
      Authorization: `Bearer ${accessToken}`, // si tienes un token de autenticación
    };

    // Construye la URL completa
    const url = `${apiUrl}/${endpoint}`;

    const response = await fetch(url, {
      method: method,
      headers: headers,
      body: data ? JSON.stringify(data) : null,
    });

    // Verifica si la respuesta es exitosa
    if (!response.ok) {
      return handleError(response); // Pasa la respuesta directamente a handleError

      // Manejar errores HTTP
      // if (response.status === 500) {
      //   return handleError(response, 'Error interno del servidor.');
      // } else if (response.status === 422) {

      //   return handleError(response, 'Error de validación.');
      // } else {
      //   return handleError(response, 'Error en la solicitud.');
      // }
    }

    // Si la solicitud fue exitosa, devuelve los datos
    return await response.json();
  } catch (error) {
    // Maneja errores de red y otros
    return handleError(error, "Error de conexión.");
  }
}

// Función auxiliar para manejar errores
async function handleError(error, defaultMessage = "Error en la solicitud.") {
  let errorMessage = defaultMessage;
  let errorData = null;

  if (error instanceof Response) {
    if (error.status === 422) {
      // Manejo específico para errores 422
      try {
        errorData = await error.json();
        //Verifica si la estructura es la esperada antes de usarla
        if (errorData.errors) {
          return { error: true, errors: errorData.errors, return: false };
        } else {
          errorMessage =
            "Error de validación: " + (errorData.message || errorMessage);
        }
      } catch (jsonError) {
        errorMessage = "Error de validación (JSON inválido): " + errorMessage;
      }
    } else if (error.status === 500) {
      errorMessage = "Error interno del servidor.";
    } else {
      try {
        errorData = await error.json();
        errorMessage = errorData.message || errorMessage;
      } catch (e) {
        errorMessage = "Error del servidor: " + errorMessage;
      }
    }
  }

  return { error: true, message: errorMessage, return: false };
}
// async function handleError(error, message) {
//   let errorMessage = message;

//   // Intenta obtener el mensaje de error del servidor
//   if (error.status && error.statusText) {
//     errorMessage = error.statusText; // Usa la respuesta del servidor
//   } else if (error instanceof Response) {
//     // Intenta obtener el error del servidor, si es un objeto JSON
//     try {
//       const errorData = await error.json();
//       errorMessage = errorData.message || errorMessage; // Prioriza el mensaje del servidor
//     } catch (e) {
//       // No es un JSON válido
//       errorMessage = 'Error de servidor: ' + errorMessage;
//     }
//   }

//   // Devuelve el error en formato JSON
//   return {
//     error: true,
//     message: errorMessage,
//   };
// }

// Función para realizar una petición GET
export async function get(endpoint) {
  // console.log("accessToken",accessToken);

  return apiRequest("GET", endpoint);
}

// Función para realizar una petición POST
export async function post(endpoint, data) {
  return apiRequest("POST", endpoint, data);
}

// Función para realizar una petición PUT
export async function put(endpoint, data) {
  return apiRequest("PUT", endpoint, data);
}

// Función para realizar una petición DELETE
export async function del(endpoint) {
  return apiRequest("DELETE", endpoint);
}

export function linkApi() {
  return apiUrl;
}

// Ejemplo de uso
// get('/users')
//   .then(data => {
//     console.log('Datos de usuarios:', data);
//   })
//   .catch(error => {
//     console.error('Error:', error);
//   });

// post('/users', { name: 'John Doe', email: 'john.doe@example.com' })
//   .then(data => {
//     console.log('Nuevo usuario creado:', data);
//   })
//   .catch(error => {
//     console.error('Error:', error);
//   });
