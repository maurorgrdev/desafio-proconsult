<template>
    <dialog-component :show="showDialog">
        <q-card-section>
            <q-form ref="myForm" class="q-gutter-md">
                <div class="row">
                    <div class="col-12">
                        <q-input 
                            outlined 
                            v-model="name" 
                            label="Nome *" 
                            :rules="[ 
                                val => val && val.length > 0 || 
                                'Obrigatório *'
                            ]"
                         />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <q-input 
                            outlined 
                            mask="###.###.###-##"
                            hint="###.###.####-##"
                            v-model="cpf" 
                            label="CPF *" 
                            :rules="[ 
                                val => val && val.length > 0 || 
                                'Obrigatório *'
                            ]"
                         />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                         <q-input 
                            outlined 
                            v-model="email" 
                            label="Email *" 
                            type="email"
                            :rules="[ 
                                val => val && val.length > 0 || 
                                'Obrigatório *'
                            ]"  
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                         <q-input 
                            outlined 
                            v-model="password" 
                            label="Senha *" 
                            :rules="[ 
                                val => val && val.length > 0 || 
                                'Obrigatório *'
                            ]" 
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <q-select outlined v-model="type" :options="options" label="Perfil" />
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
import { useUsuarioStore } from 'src/stores/user'

export default 
{
    components: { DialogComponent },

    props: ['show'],

    emits: ['closeDialog', 'createSuccess'],

    setup() {
        const useStore = useUsuarioStore()

        return {
            useStore,
        }
    },

    data() {
        return {
            showDialog: false,

            name: '',
            email: '',
            password: '',
            cpf: '',
            type: '',

            msgError: '',

            options: [
                'cliente', 'colaborador'
            ]
        }
    },

    updated() {
        this.showDialog = this.show
        
        this.name = ''
        this.email = ''
        this.descricao =''
        this.password = ''
        this.cpf = ''
        this.type =''
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
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    type: this.type,
                    cpf: this.retirarMascara(this.cpf),
                }
                
                const response = await this.useStore.addUsuario(data);
                
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

        async validationForm()
        {
            if((this.name === '') || this.name === null || this.name.length <= 0){
                this.msgError = 'Informe um nome';
                return false;
            }

            if((this.email === '') || this.email === null || this.email.length <= 0 || !this.validEmail(this.email)){
                this.msgError = 'Informe uma e-mail válido';
                return false;
            }

            if((this.password === '') || this.password === null || this.password.length <= 0){
                this.msgError = 'Informe uma senha';
                return false;
            }

            if((this.type === '') || this.type === null || this.type.length <= 0){
                this.msgError = 'Informe um perfil';
                return false;
            }

            if((this.cpf === '') || this.cpf === null || this.type.length <= 0 || !await this.validadarCpf()){
                this.msgError = 'Informe um cpf válido';
                return false;
            }

            return true;
        },

        validEmail (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },

        async validadarCpf(){
            let cpf_verificado = await this.retirarMascara(this.cpf)

            let soma = 0;
            let i;
            let resto;

            if (cpf_verificado == "00000000000") 
                return false;
            
            for (i = 1; i <= 9; i++){
                soma = soma + parseInt(cpf_verificado.substring(i - 1, i)) * (11 - i);
            }

            resto = (soma * 10) % 11;

            if (resto == 10 || resto == 11) 
                resto = 0;

            if (resto != parseInt(cpf_verificado.substring(9, 10)))
                return false;

            soma = 0;

            for (i = 1; i <= 10; i++){
                soma = soma + parseInt(cpf_verificado.substring(i - 1, i)) * (12 - i);
            }

            resto = (soma * 10) % 11;

            if (resto == 10 || resto == 11)
                resto = 0;
            
            if (resto != parseInt(cpf_verificado.substring(10, 11)))
                return false;

            return true;
        },

        retirarMascara(cpf_formated) {
            return cpf_formated.replace(/\D/g, '');
        }
    },
}

</script>