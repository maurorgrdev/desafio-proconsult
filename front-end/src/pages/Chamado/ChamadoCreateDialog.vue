<template>
    <dialog-component :show="showDialog">
        <q-card-section>
            <q-form ref="myForm" class="q-gutter-md">
                <div class="row">
                    <div class="col-12">
                        <q-input 
                            filled 
                            v-model="titulo" 
                            label="Título *" 
                            :rules="[ 
                                val => val && val.length > 0 || 
                                'Obrigatório'
                            ]"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <q-input
                            label="Descrição *"
                            v-model="descricao"
                            filled
                            type="textarea"
                            :rules="[ 
                                val => val && val.length > 0 || 
                                'Obrigatório'
                            ]"
                        />
                    </div>
                </div>
            </q-form>
        </q-card-section>
        <q-card-actions class="row text-primary" style="padding-left: 15px; padding-right: 15px;">
            <q-btn @click="clickCancel" outline style=" width: 150px; color: primary;" label="Cancelar" />
            <q-space />
            <q-btn @click="clickSubmit" style=" width: 150px;" color="primary" label="Salvar" />
          </q-card-actions>
    </dialog-component>
</template>

<script>

import DialogComponent from 'src/components/DialogComponent.vue'
import { useChamadoStore } from 'src/stores/chamado'

export default 
{
    components: { DialogComponent },

    props: ['show'],

    emits: ['closeDialog', 'createSuccess'],

    setup() {
        const chamadoStore = useChamadoStore()

        return {
            chamadoStore,
        }
    },

    data() {
        return {
            showDialog: false,

            titulo: '',
            descricao: '',

            msgError: '',
        }
    },

    updated() {
        this.showDialog = this.show
        
        this.titulo = ''
        this.descricao =''
    },

    methods: {
        clickCancel()
        {
            this.showDialog = false
            this.$emit('closeDialog');
        },

        async clickSubmit()
        {
            if(await this.validationForm()){
                let data = {
                    titulo: this.titulo,
                    descricao: this.descricao,
                }
                
                const response = await this.chamadoStore.addChamado(data);
                
                console.log(response);
                if(response.status === 201){
                    this.showDialog = false
                    this.$emit('createSuccess');
                } else {
                    alert('Erro ao cadastrar usuário');
                }
            } else {
                alert(this.msgError);
            }
        },

        validationForm()
        {
            if((this.titulo === '') || this.titulo === null || this.titulo.length <= 0){
                this.msgError = 'Informe um título';
                return false;
            }

            if((this.descricao === '') || this.descricao === null || this.descricao.length <= 0){
                this.msgError = 'Informe uma descrição';
                return false;
            }

            return true;
        }
    },
}

</script>