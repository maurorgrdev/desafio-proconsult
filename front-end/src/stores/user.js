import { defineStore } from 'pinia'
import { api } from 'boot/axios'

export const useUsuarioStore = defineStore("usuario", {
    persist: true,
    state: () => ({
        usuario: {},
    }),
    getters: {
      getUsuario(state){
          return state.usuario
        }
    },
    actions: {
        async login(data){
            try {
                const response = await api.post('/login', data);

                this.usuario = response.data.data.user;
                
                await localStorage.setItem("token", response.data.data.token);

                return response;
            } catch (error) {
                localStorage.setItem("token", '');
                this.usuario = {};

                return error.response;
            }
        },

        async loadUsuario(){
            try {
                const response = await api.get('/user/show-user-log');
                
                this.usuario = response.data;

                return true;
            } catch (error) {

                return false;
            }
        },

        async logout(){
            try {
                this.usuario = {};
                await localStorage.removeItem("token");
            } catch (error) {
                return false;
            }
        },
    },
  });