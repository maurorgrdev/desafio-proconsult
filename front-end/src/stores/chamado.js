import { defineStore } from 'pinia'
import { api } from 'boot/axios'

export const useChamadoStore = defineStore("chamado", {
    state: () => ({
        chamados: [],
        chamado: {},
    }),

    getters: {
      getChamado(state){
        return state.chamado
      },
      
      getChamados(state){
        return state.chamados;
      },

      getChamadosToTable(state){
        const chamadoTemp = state.chamados.map((chamado) => {
            return  {
                ...chamado
            }
        });
        
        return chamadoTemp;
      }
    },

    actions: {
      async loadChamado(id){
        try {
          const data = await api.get(`/chamados/${id}`)
          this.chamado = {...data.data}
        }
          catch (error) {
            alert(error)
            
        }
      },

      async loadChamados() {
        try {
          const result = await api.get('/chamados')
          this.chamados = result.data.data
        }
          catch (error) {
            alert(error)
        }
      },

      async addChamado(data){
        try {
          const response = await api.post('/chamados', data);

          return response;

        } catch (error) {
          
          return error.response;
        }
      },

      async editChamado(data){
        try {
          const response = await api.patch(`/chamados/${data.id}`, data);

          return response.data;
        } catch (error) {
          return error;
        }
      }
    },
  });