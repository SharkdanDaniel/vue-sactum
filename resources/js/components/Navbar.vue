<template>
    <q-header elevated :class="{ 'bg-blue-grey-10' : $q.dark.isActive }">
        <q-toolbar>
            <q-btn flat @click="buttonClicked" round dense icon="fa-solid fa-bars" />
            <DarkToggle />
            <q-toolbar-title>{{ routerName }}</q-toolbar-title>
            <q-avatar class="cursor-pointer">
                <img src="https://cdn.quasar.dev/img/avatar.png">
                <q-menu>
                    <q-list style="min-width: 100px">
                        <q-item clickable v-close-popup>
                            <q-item-section>{{ profile?.name }}</q-item-section>
                        </q-item>
                        <q-separator />
                        <q-item clickable v-close-popup @click="logout">
                            <q-item-section class="font-bold">Sair</q-item-section>
                        </q-item>                                             
                    </q-list>
                </q-menu>
            </q-avatar>
        </q-toolbar>
    </q-header>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from 'vue'
import { useRoute } from 'vue-router';
import { UserProps } from '../models/User.model';
import { getAuthUser, onLogout } from '../services/authService';
import DarkToggle from './DarkToggle.vue';

export default defineComponent({
    name: "NavbarComponent",
    components: { DarkToggle },
    emits: ["onMenuClicked"],
    methods: { buttonClicked(e: Event) { this.$emit("onMenuClicked", e); } },
    setup() {
        const profile = ref<UserProps>();
        const getAuth = async () => {
            try {
                profile.value = (await getAuthUser())?.data;
            }
            finally { }
        };
        const logout = async () => {
            await onLogout();
        };
        const $route = useRoute();
        getAuth();
        return {
            profile,
            logout,
            routerName: computed(() => $route.name),
        };
    },
    
})
</script>


<style lang="scss" scoped>
.q-header {
    background-color: $grey-9;
}
</style>