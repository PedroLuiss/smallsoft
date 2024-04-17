import axios from "axios";
export default {

  async getPaises() {
    const data =  await axios.get("https://www.universal-tutorial.com/api/getaccesstoken",{ headers:{
        "Accept": "application/json",
        "api-token": "Zg5KFEd5KFMHYXLzSTKTSX8h9xu4rq5lv8_ngN_ukGN8AmwA1HIvYQs5rN7qYst7jGM",
        "user-email": "peluisrodriguez2@gmail.com"
    }});
    if (data.data) {
        var auth_token = data.data.auth_token;
        const datapais =  await axios.get("https://www.universal-tutorial.com/api/countries/",{ headers:{
            "Authorization": "Bearer "+auth_token,
            "Accept": "application/json",
        }});   
        if (datapais.data) {
            var countries = datapais.data;
            console.log(countries);

            return countries
        }      
    }

  }

};
