<template>
    <q-header elevated :class="{ 'bg-blue-grey-10' : $q.dark.isActive }">
        <q-toolbar>
            <q-btn flat @click="buttonClicked" round dense icon="fa-solid fa-bars" />
            <DarkToggle />
            <q-toolbar-title>{{ routerName }}</q-toolbar-title>
            <q-skeleton size="38px" v-if="loading" type="QAvatar" />
            <q-avatar v-else class="cursor-pointer bg-white">
                <img v-if="profile?.avatar?.src" :src="profile?.avatar?.src">
                <img v-else src="@/assets/icons/avatar.svg">
                <q-menu>
                    <q-list style="min-width: 100px">
                        <q-item class="justify-center items-center flex-col" clickable v-close-popup @click="openAvatarDialog">                            
                            <q-avatar class="cursor-pointer bg-white">
                                <img v-if="profile?.avatar?.src" :src="profile?.avatar?.src">
                                <img v-else src="@/assets/icons/avatar.svg">
                            </q-avatar>
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
    <AvatarDialog />
</template>

<script lang="ts">
import { computed, defineComponent, ref } from 'vue'
import { useRoute } from 'vue-router';
import { useQuasar } from 'quasar';
import { UserProps } from '../models/User.model';
import { getAuthUser, onLogout } from '../services/authService';
import DarkToggle from './DarkToggle.vue';
import AvatarDialog from './AvatarDialog.vue';

export default defineComponent({
    name: "NavbarComponent",
    components: { DarkToggle, AvatarDialog },
    emits: ["onMenuClicked"],
    methods: { buttonClicked(e: Event) { this.$emit("onMenuClicked", e); } },
    data() {
        return {
            avatarIcon: '../assets/icons/avatar.svg'
        }
    },
    setup() {
        const $q = useQuasar();
        const profile = ref<UserProps>();
        const loading = ref(false);
        const openAvatarDialog = () => {
            $q.dialog({
                component: AvatarDialog,
                componentProps: { avatar: profile.value?.avatar },
            }).onOk((data) => profile.value && (profile.value.avatar = data))
        }
        const getAuth = async () => {
            try {
                loading.value = true;
                const { data } = await getAuthUser();
                profile.value = data;
            }
            finally {
                loading.value = false;                
            }
        };
        const logout = async () => {
            await onLogout();
        };
        const $route = useRoute();
        getAuth();
        return {
            profile,
            logout,
            loading,
            openAvatarDialog,
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
