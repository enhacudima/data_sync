import axios from 'axios';
import store from './loginLogout';
import EventBus  from "./event-bus";
import {routes} from './routes';

export default function setup() {
    axios.interceptors.request.use(function(config) {
        const token = store.getters.token;
        if(token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    }, function(err) {
        store.dispatch('logout')
        return Promise.reject(err);
    });

    axios.interceptors.response.use(
    function(response) {

        const status = response.status;
        const data = response.data;
        statusCode(status,data);
        return response;
    },
    function(error) {
        const status = error.response.status;
        const data = error.response.data;

        statusCode(status,data);
        return Promise.reject(error);
    }
    );


    function event(text, color) {
        EventBus.$emit('snackBar', {
            text: text,
            color: color,
            model: true,
        })
    }
    function statusCode(status,data) {
        if (status === 200) {
            if(data.success)
                {
                    event(data.success, 'success');
                }
        }else if (status === 401) {
            store.dispatch('logout')
        }else if(status === 403){
            event(data.message, 'red lighten-1');
        }else if(status === 422){
            event(data.errors[0], 'red lighten-1');
        }else if(status === 429){
            event("Tente mais tarde.", 'red lighten-1');
        }else{
            event("Erro não esperado.", 'red lighten-1');
        }


    }
}


