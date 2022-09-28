<template>
    <q-dialog ref="dialogRef" @hide="onDialogHide">
        <q-card class="q-dialog-plugin">
            <!--
        ...content
        ... use q-card-section for it?
      -->

            <!-- buttons example -->
            <q-card-actions align="right">
                <q-btn color="primary" label="Salvar" @click="onOKClick" />
                <q-btn color="light" label="Cancelar" @click="onCancelClick" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { useDialogPluginComponent } from 'quasar'

export default defineComponent({
    name: 'AvatarDialogComponent',
    emits: [...useDialogPluginComponent.emits],
    setup() {
        const { dialogRef, onDialogHide, onDialogOK, onDialogCancel } = useDialogPluginComponent()
        return {
            dialogRef,
            onDialogHide,
            onOKClick() {
                onDialogOK()
            },
            onCancelClick: onDialogCancel
        }
    },
})
</script>
