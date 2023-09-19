<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          Chamados
        </q-toolbar-title>

        <div>
          <q-btn
          flat
          dense
          round
          icon="logout"
          @click="logoutUser()"
        />
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label
          header
        >
          {{ usuarioStore.usuario.name}}
        </q-item-label>

        <q-item clickable>
          <q-item-section @click="$router.push('/chamados')">Chamados</q-item-section>
        </q-item>
        <q-item clickable>
          <q-item-section @click="$router.push('/usuarios')">Usuarios</q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { useUsuarioStore } from 'src/stores/user'

export default defineComponent({
  name: 'MainLayout',

  components: {
    // EssentialLink
  },

  setup () {
    const leftDrawerOpen = ref(false)
    const usuarioStore = useUsuarioStore()

    return {
      leftDrawerOpen,
      toggleLeftDrawer () {
        leftDrawerOpen.value = !leftDrawerOpen.value
      },
      usuarioStore
    }
  },

  methods: {
    async logoutUser(){
      await this.usuarioStore.logout();
      this.$router.push('/login');
    }
  },
})
</script>
