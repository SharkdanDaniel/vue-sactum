<template>
    <router-view></router-view>
</template>

<script lang="ts">
import { defineComponent, watch } from 'vue';
import { useQuasar } from 'quasar'
import { useAuthStore } from './store/auth';
import { getAuthData, getAuthUser } from './services/authService';

export default defineComponent({
    setup() {
        const authStore = useAuthStore();
        if(getAuthData()) authStore.setAuth(getAuthData() as any);
        const $q = useQuasar();
        let theme: 'dark' | 'light' = localStorage.getItem('laravue@theme') as any;
        if(!theme) {
            theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            localStorage.setItem('laravue@theme', theme);
        }
        $q.dark.set(theme === 'dark' ? true : false);
        watch(() => $q.dark.isActive, val => {
            localStorage.setItem('laravue@theme', val ? 'dark' : 'light');
        })
    },
})
</script>

<style lang="scss">
body {
    background-color: $grey-2;
}
</style>
