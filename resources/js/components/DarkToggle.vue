<template>
    <q-toggle class="dark-toggle" v-model="isDark" icon="fa-solid fa-moon" @click="darkToggle" />
</template>

<script lang="ts">
import { useQuasar } from 'quasar';
import { defineComponent, ref } from 'vue'

export default defineComponent({
    name: 'DarkToggleComponent',
    setup() {
        const $q = useQuasar();        
        const isDark = ref($q.dark.isActive);
        const darkToggle = () => $q.dark.toggle();
        return { darkToggle, isDark, }
    },
})
</script>
