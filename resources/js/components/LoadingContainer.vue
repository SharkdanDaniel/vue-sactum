<template>
    <div v-if="loading" class="loading-container">
        <q-spinner-bars color="primary" size="2em" />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'LoadingContainerComponent',
    props: { loading: { type: Boolean, required: true } }
})
</script>

<style scoped>
.loading-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    position: absolute;
    width: 100%;
    background: rgba(0, 0, 0, 0.3);
    z-index: 9999;
}
</style>