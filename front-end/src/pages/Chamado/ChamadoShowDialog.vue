<template>
    <dialog-component :show="showDialog">
        <q-card-section>
            <q-form ref="myForm" class="q-gutter-md">
                <div class="row">
                    <div class="col-12">
                        <q-input 
                            disable 
                            filled 
                            v-model="titulo"
                            label="Titulo"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <q-input
                            label="Descrição"
                            disable
                            filled
                            v-model="descricao"
                            type="textarea"
                        />
                    </div>
                </div>
                <div v-if="dados.status == 'Em Andamento' || dados.status == 'Concluído'">
                    <div class="text-subtitle1">Colaborador</div>
                    <div class="row">
                        <div class="col-12">
                            <q-input
                                disable 
                                filled 
                                label="Descricao colaborador *"
                                v-model="descricao_colaborador"
                                type="textarea"
                            />
                        </div>
                    </div>
                    <div class="row" v-if="!(dados.colaborador_arquivo == null)">
                        <div class="col-10">
                            <q-file 
                                outlined 
                                disable  
                                v-model="arquivoColaborador"
                            >
                                <template v-slot:prepend>
                                <q-icon name="attach_file" />
                                </template>
                            </q-file>  
                        </div>
                        <div class="col-2">
                            <q-btn icon="download" @click="download(dados.colaborador_arquivo.id, arquivoColaborador[0].name)"></q-btn>
                        </div>
                    </div>
                </div>
                <div v-if="dados.status == 'Concluído'">
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
                    <div class="row" v-if="!(dados.cliente_arquivo == null)">
                        <div class="col-10">
                            <q-file 
                                outlined 
                                disable  
                                v-model="arquivoCliente"
                            >
                                <template v-slot:prepend>
                                <q-icon name="attach_file" />
                                </template>
                            </q-file>
                        </div>
                        <div class="col-2">
                            <q-btn icon="download" @click="download(dados.cliente_arquivo.id, arquivoCliente[0].name)"></q-btn>
                        </div>
                    </div>
                </div>
            </q-form>
        </q-card-section>
        <q-card-actions class="row text-primary" style="padding-left: 15px; padding-right: 15px;">
            <q-btn @click="clickCancel" outline style=" width: 150px; color: primary;" label="Voltar" />
            <q-space />
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

    emits: ['closeDialog'],

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
            arquivoCliente: [],
            arquivoColaborador: [],
        }
    },

    beforeUpdate() {
        this.showDialog = this.show

        this.titulo = this.dados.titulo
        this.descricao = this.dados.descricao
        this.descricao_colaborador = this.dados.colaborador_resposta
        this.descricao_cliente = this.dados.cliente_resposta

        console.log(this.dados.cliente_arquivo);
        console.log(this.dados.colaborador_arquivo);
        /**
         * Recuperar arquivo do colaborador
        */
        if(!(this.dados.colaborador_arquivo === null)){
            this.arquivoColaborador = [{
                name: this.dados.colaborador_arquivo.name,
                lastModified: 0,
                size: 0,
                tipo: "",
                webkitRelativePath: "",
            }]
        } else {
            this.arquivoColaborador = []
        }

        /**
         * Recuperar arquivo do cliente
        */
        if(!(this.dados.cliente_arquivo === null)){
            this.arquivoCliente = [{
                name: this.dados.cliente_arquivo.name,
                lastModified: 0,
                size: 0,
                tipo: "",
                webkitRelativePath: "",
            }]
        } else {
            this.arquivoCliente = []
        }

        this.arquivo = []
    },

    methods: {
        clickCancel()
        {
            this.showDialog = false
            this.$emit('closeDialog');
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

        async download(chamado_id, file_name){
            await api.get(`/arquivo-chamado/download/${chamado_id}`, {
                baseURL: 'http://localhost:8000/api/',
                responseType: 'blob',
            }).then((response) => {
                const fileUrl = window.URL.createObjectURL(new Blob([response.data]))
                
                let fileLink = document.createElement('a')
                fileLink.href = fileUrl
                fileLink.setAttribute('download', file_name)
                document.body.appendChild(fileLink)
                fileLink.click();
            });
        }
    },
}

</script>