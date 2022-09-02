<template>
    <q-header elevated>
        <q-toolbar>
          <q-btn
            flat
            @click="buttonClicked"
            round
            dense
            icon="fa-solid fa-bars"
          />
          <q-toggle v-model="isDark" icon="fa-solid fa-moon" @click="darkToggle" />
          <q-toolbar-title>{{ routerName }}</q-toolbar-title>
        </q-toolbar>
      </q-header>
</template>

<script lang="ts">
import { useQuasar } from 'quasar';
import { computed, defineComponent, ref } from 'vue'
import { useRoute } from 'vue-router';

export default defineComponent({
    name: 'NavbarComponent',
    emits: ['onMenuClicked'],
    methods: { buttonClicked(e: Event) { this.$emit('onMenuClicked', e) } },
    setup() {
        const $q = useQuasar();
        const isDark = ref($q.dark.isActive);
        const darkToggle = () => $q.dark.toggle();
        const $route = useRoute();
        return {
            darkToggle,
            isDark,
            routerName: computed(() => $route.name),
        }
    },
})
</script>


<style lang="scss" scoped>
    .q-header {
        background-color: $grey-9;
    }
</style>