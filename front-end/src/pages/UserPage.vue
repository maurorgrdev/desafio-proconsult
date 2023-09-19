<template>
    <q-page>   
        <usuario-create-dialog 
            :show="showDialogNovoUsuario" 
            v-on:close-dialog="callBackCloseNovousuario" 
            v-on:create-success="callBackNovoUsuarioSuccess"
        />

        <q-table 
        flat bordered 
        title="Usuários" 
        :rows="usuarios" 
        :columns="columns" 
        row-key="id" 
      >
        <template v-slot:body="props">
            <q-tr :props="props">
                <q-td key="id" :props="props">
                    {{ props.row.id }}
                </q-td>
                <q-td key="name" :props="props">
                    {{ props.row.name }}
                </q-td>
                <q-td key="email" :props="props">
                    {{ props.row.email }}
                </q-td>
                <q-td key="type" :props="props">
                    {{ props.row.type }}
                </q-td>
            </q-tr>
        </template>
        <template v-slot:top>
            <q-space />
            <q-btn v-if="(this.userStore.usuario.type == 'admin')" color="primary" label="NOVO USUÁRIO"  @click="openDialogNovoUsuario"/>
          </template>
      </q-table>
    </q-page>
</template>

<script>
import { useUsuarioStore } from 'src/stores/user'
import UsuarioCreateDialog from './User/UsuarioCreateDialog.vue'

export default {
    components: { UsuarioCreateDialog },

    setup() {
        const userStore = useUsuarioStore()

        return {
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
                { name: 'name', align: 'center', label: 'Nome', field: 'name', sortable: true },
                { name: 'email', align: 'center', label: 'Email', field: 'email', sortable: true },
                { name: 'type', align: 'center', label: 'Perfil', field: 'type', sortable: true },
            ],


            showDialogNovoUsuario: false,

            usuarios: [],
        }
    },

    async mounted() {
        await this.userStore.loadUsuarios();

        this.usuarios = this.userStore.getUsuarios;
    },

    methods: {
        openDialogNovoUsuario(){
            this.showDialogNovoUsuario = true
        },

        callBackCloseNovousuario(){
            this.showDialogNovoUsuario = false
        },

        async callBackNovoUsuarioSuccess(){
            await this.userStore.loadUsuarios();

            this.showDialogNovoUsuario = false
        }
    },
}
</script>