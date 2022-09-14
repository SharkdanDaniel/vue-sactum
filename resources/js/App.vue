<template>
    <router-view></router-view>
</template>

<script lang="ts">
import { defineComponent, watch } from 'vue';
import { useQuasar } from 'quasar'

export default defineComponent({
    setup() {
        const $q = useQuasar();

        watch(() => $q.dark.isActive, val => {
        })
    },
})
</script>

<style lang="scss">
body {
    background-color: $grey-2;
}
</style>
