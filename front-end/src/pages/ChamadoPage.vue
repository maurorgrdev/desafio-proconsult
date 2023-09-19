<template>
    <chamado-create-dialog 
        :show="showDialogNovoChamado" 
        v-on:close-dialog="callBackCloseNovoChamado" 
        v-on:create-success="callBackNovoChamadoSuccess"
    />

    <chamado-responde-dialog 
        :show="showDialogEditChamado" 
        :dados="dadosChamado"
        :tipo="userStore.usuario.type"
        v-on:close-dialog="callBackCloseEditChamado" 
        v-on:update-success="callBackEditaChamadoSuccess"
    />

    <chamado-show-dialog 
        :show="showDialogShowChamado" 
        :dados="dadosChamado"
        :tipo="userStore.usuario.type"
        v-on:close-dialog="callBackCloseShowChamado" 
    />
    
    <q-page>   
        <q-table 
        flat bordered 
        title="Treats" 
        :rows="chamadoStore.getChamados" 
        :columns="columns" 
        row-key="id" 
      >
        <template v-slot:body="props">
            <q-tr :props="props">
                <q-td key="id" :props="props">
                    {{ props.row.id }}
                </q-td>
                <q-td key="titulo" :props="props">
                    {{ props.row.titulo }}
                </q-td>
                <q-td key="status" :props="props">
                    {{ props.row.status }}
                </q-td>
                <q-td key="descricao" :props="props">
                    {{ props.row.descricao }}
                </q-td>
                <q-td key="actions" :props="props">
                    <q-btn v-if="(this.userStore.usuario.type == 'colaborador') && (props.row.status == 'Aberto')" icon="mode_edit" @click="openDialogEditaChamado(props.row)"></q-btn>
                    <q-btn v-else-if="(this.userStore.usuario.type == 'cliente') && (props.row.status == 'Em Andamento')" icon="mode_edit" @click="openDialogEditaChamado(props.row)"></q-btn>
                    <q-btn icon="visibility" @click="openDialogVisualizaChamado(props.row)"></q-btn>
                </q-td>
            </q-tr>
        </template>
        <template v-slot:top>
            <q-space />
            <q-btn v-show="userStore.usuario.type == 'cliente'" color="primary" label="NOVO CHAMADO"  @click="openDialogNovoChamado"/>
          </template>
      </q-table>
    </q-page>
</template>

<script>
// import TableComponente from 'components/TableComponente.vue';
import { useChamadoStore } from 'src/stores/chamado'
import { useUsuarioStore } from 'src/stores/user'
import ChamadoCreateDialog from './Chamado/ChamadoCreateDialog.vue'
import ChamadoRespondeDialog from './Chamado/ChamadoRespondeDialog.vue'
import ChamadoShowDialog from './Chamado/ChamadoShowDialog.vue'

export default {
    components: { ChamadoCreateDialog, ChamadoRespondeDialog, ChamadoShowDialog },

    setup() {
        const chamadoStore = useChamadoStore()
        const userStore = useUsuarioStore()

        return {
            chamadoStore,
            userStore,
        }
    },

    data() {
        return {
            columns: [
                {
                    name: 'id',
                    label: 'Código',
                    align: 'center',
                    field: 'Código',
                    sortable: true
                },
                { name: 'titulo', align: 'center', label: 'Títutlo', field: 'titulo', sortable: true },
                { name: 'status', align: 'center', label: 'Status', field: 'status', sortable: true },
                { name: 'descricao', align: 'center', label: 'Descrição', field: 'descricao', sortable: true },
                { name: 'actions', align: 'center', label: 'Ações'},
            ],

            // dadosChamado: [],

            showDialogNovoChamado: false,
            showDialogEditChamado: false,
            showDialogShowChamado: false,

            dadosChamado: {},
        }
    },

    async mounted() {
        await this.chamadoStore.loadChamados();

        // this.dados = this.chamadoStore.getChamados;
    },

    methods: {
        openDialogNovoChamado()
        {
            this.showDialogNovoChamado = true;
        },

        callBackCloseNovoChamado()
        {
            this.showDialogNovoChamado = false
        },

        async callBackNovoChamadoSuccess()
        {
            await this.chamadoStore.loadChamados();

            this.showDialogNovoChamado = false
        },

        openDialogEditaChamado(chamado)
        {
            this.dadosChamado = {...chamado};
            this.showDialogEditChamado = true;
        },

        callBackCloseEditChamado()
        {
            this.showDialogEditChamado = false
        },

        async callBackEditaChamadoSuccess()
        {
            await this.chamadoStore.loadChamados();

            this.showDialogEditChamado = false
        },

        openDialogVisualizaChamado(chamado)
        {
            this.dadosChamado = {...chamado};
            this.showDialogShowChamado = true;
        },

        callBackCloseShowChamado(){
            this.showDialogShowChamado = false
        }
    },
}
</script>
  