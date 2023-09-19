<template>
    <dialog-component :show="showDialog">
        <q-card-section>
            <q-form ref="myForm" class="q-gutter-md">
                <div class="row">
                    <div class="col-12">
                        <q-input disable filled v-model="titulo" label="Título *" hint="Título" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <q-input
                            disable
                            v-model="descricao"
                            filled
                            type="textarea"
                        />
                    </div>
                </div>

                
                <div v-if="tipo=='colaborador'">
                    <div class="text-subtitle1">Colaborador</div>
                    <div class="row">
                        <div class="col-12">
                            <q-input
                                label="Descricao colaborador *"
                                v-model="descricao_colaborador"
                                filled
                                type="textarea"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <q-file outlined v-model="arquivo">
                                <template v-slot:prepend>
                                <q-icon name="attach_file" />
                                </template>
                            </q-file>  
                        </div>
                    </div>
                </div>

                <div v-if="tipo=='cliente'">
                    <div class="text-subtitle1">Cliente</div>
                    <div class="row">
                        <div class="col-12">
                            <q-input
                                label="Descricao cliente *"
                                v-model="descricao_cliente"
                                filled
                                type="textarea"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <q-file outlined v-model="arquivo">
                                <template v-slot:prepend>
                                <q-icon name="attach_file" />
                                </template>
                            </q-file> 
                        </div>
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

import axios, { api } from 'src/boot/axios'
import DialogComponent from 'src/components/DialogComponent.vue'
import { useChamadoStore } from 'src/stores/chamado'

export default 
{
    components: { DialogComponent },

    props: ['show', 'dados', 'tipo'],

    emits: ['closeDialog', 'updateSuccess'],

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
            descricao_colaborador: '',
            descricao_cliente: '',


            arquivo: [],
        }
    },

    updated() {
        this.showDialog = this.show

        this.titulo = this.dados.titulo
        this.descricao = this.dados.descricao
        this.descricao_colaborador = this.dados.colaborador_resposta
        this.descricao_cliente = this.dados.cliente_resposta

        this.arquivo = []
    },

    methods: {
        clickCancel()
        {
            console.log(this.arquivo);
            this.showDialog = false
            this.$emit('closeDialog');
        },

        async clickSubmit()
        {
            let data = {
                id: this.dados.id,
                colaborador_resposta: this.descricao_colaborador,
                cliente_resposta: this.descricao_cliente,
                status: this.dados.status,
                titulo: this.titulo,
                descricao: this.descricao,
            }

            console.log(Object.keys(this.arquivo).length);
            if(!(Object.keys(this.arquivo).length === 0)){
                await this.uploadArquivoChamado(this.arquivo, this.dados.id);
            }

            const response = await this.chamadoStore.editChamado(data);

            if(response){
                this.showDialog = false
                this.$emit('updateSuccess');
            } else {
                console.log(response);
            }
        },

        async uploadArquivoChamado(arquivoChamado, chamado_id){
            let form = new FormData()
            form.append('file', arquivoChamado)
            form.append('name', arquivoChamado.name)
            form.append('chamado_id', chamado_id)

            try {
                const responseUpload = await api.post("/arquivo-chamado/upload", form, {
                baseURL: 'http://localhost:8000/api/',
                headers: {
                    "Content-Type": "multipart/form-data"
                }
                });

                return responseUpload.data;
            } catch (error) {
                return error;
            }
        },
    },
}

</script>