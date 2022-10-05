<template>
    <q-dialog ref="dialogRef" @hide="onDialogHide">
        <q-card class="q-dialog-plugin">
            <LoadingContainer :loading="loading" />
            <q-card-section class="sm:h-96 flex justify-center items-center">
                <input hidden type="file" ref="avatarInput" @change="handleFileInput">
                <vue-cropper
                    v-if="imgSrc"
                    ref="vueCropperRef"
                    :src="imgSrc"
                    alt="Source Image"
                    :aspect-ratio="4/3"
                    class="h-full w-full"
                />
                <span
                    class="text-lg cursor-pointer text-blue-400 font-bold"
                    @click="triggerFileInput"
                >{{ imgSrc ? 'Alterar avatar' : 'Carregar avatar' }}</span>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn color="primary" label="Salvar" @click="onSave" />
                <q-btn
                    :color="$q.dark.isActive ? 'secondary' : 'grey-3'"
                    :text-color="$q.dark.isActive ? 'white' : 'grey-10'"
                    label="Cancelar"
                    @click="onCancelClick"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script lang="ts">
import { defineComponent, PropType, ref } from 'vue'
import { useDialogPluginComponent, useQuasar } from 'quasar'
import VueCropper, { VueCropperInstance } from '@ballcat/vue-cropper';
import { createAvatar, updateAvatar } from '../services/avatarService'
import LoadingContainer from './LoadingContainer.vue';
import { UserAvatarProps } from '../models/User.model';

export default defineComponent({
    name: 'AvatarDialogComponent',
    emits: [...useDialogPluginComponent.emits],
    components: { VueCropper, LoadingContainer },
    props: { avatar: { type: Object as PropType<UserAvatarProps>, required: false } },
    methods: {
        triggerFileInput() {
            (this.$refs['avatarInput'] as any).click()
        }
    },
    mounted() {
        if(this.avatar?.src) {
            this.imgSrc = this.avatar.src;
            this.isEditing = true;
        };
    },
    setup(props) {
        const $q = useQuasar();
        const { dialogRef, onDialogHide, onDialogOK, onDialogCancel } = useDialogPluginComponent();
        const vueCropperRef = ref<VueCropperInstance>(null!);
        const loading = ref(false);
        const isEditing = ref(false);
        const handleFileInput = ({ target }: any) => {
            imgSrc.value = URL.createObjectURL(target?.files[0])
        }
        const onSave = async () => {
            vueCropperRef.value.getCroppedCanvas().toBlob((blob: any) => {
                const formData = new FormData();
                formData.append('image', blob);
                const submitAvatar = async () => {
                    try {
                        loading.value = true;
                        const { data } = await (isEditing.value ? updateAvatar(props.avatar?.id!, formData) : createAvatar(formData))
                        loading.value = false;
                        $q.notify({
                            color: 'positive',
                            message: `Avatar ${isEditing.value ? 'atualizado' : 'adicionado'} com sucesso!`,
                            position: window.innerWidth <= 600 ? 'top' : 'top-right',
                            classes: window.innerWidth <= 600 ? 'full-width' : '',
                        })
                        onDialogOK(data);
                    } finally {
                        loading.value = false;
                    }
                }
                submitAvatar();
            });
        }
        const imgSrc = ref('');
        return {
            dialogRef,
            imgSrc,
            vueCropperRef,
            handleFileInput,
            onDialogHide,
            onSave,
            isEditing,
            loading,
            onCancelClick: onDialogCancel
        }
    },
})
</script>
