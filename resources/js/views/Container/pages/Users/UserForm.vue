<template>
    <div class="text-h4 q-pb-md">{{ isEditing ? 'Editar' : 'Atualizar' }} Usuário</div>
    <q-card class="q-pa-sm shadow-10">
        <q-card-section v-if="loading">
            <q-skeleton type="QInput" height="2.4rem" class="mb-10" />
            <q-skeleton type="QInput" height="2.4rem" class="mb-10" />
            <q-skeleton type="QInput" height="2.4rem" class="mb-10" />
            <q-card-actions style="gap: 10px" :class="$q.screen.lt.sm ? 'column' : 'justify-end'">
                <q-skeleton type="QBtn" class="custom-btn" :class="{ 'full-width': $q.screen.lt.sm }" />
                <q-skeleton type="QBtn" class="custom-btn" :class="{ 'full-width': $q.screen.lt.sm }" />
            </q-card-actions>
        </q-card-section>
        <q-card-section v-else>
            <q-form @submit.prevent="onSubmit">
                <div class="mb-5">
                    <q-input 
                        ref="inputRef" 
                        type="text" 
                        v-model="form.name" 
                        label="Nome" 
                        dense 
                        outlined
                        :rules="[() => getErrorMessage(v$.form.name)]" 
                    />
                </div>
                <div class="mb-5">
                    <q-input 
                        ref="inputRef" type="email" 
                        v-model="form.email" 
                        label="Email" 
                        dense 
                        outlined
                        :rules="[() => getErrorMessage(v$.form.email)]"
                    />
                </div>
                <div class="mb-5">
                    <q-input 
                        ref="inputRef" 
                        type="password" 
                        v-model="form.password" 
                        label="Senha" 
                        dense 
                        outlined
                        :rules="[() => getErrorMessage(v$.form.password)]" 
                    />
                </div>
                <q-card-actions style="gap: 10px" :class="$q.screen.lt.sm ? 'column' : 'justify-end'">
                    <router-link to="../users" :class="{ 'full-width': $q.screen.lt.sm }">
                        <q-btn 
                            :disable="submitLoading" 
                            type="button" 
                            size="md" 
                            text-color="grey-10" 
                            color="grey-1"
                            class="custom-btn" 
                            :class="{ 'full-width': $q.screen.lt.sm }"
                        >Voltar</q-btn>
                    </router-link>
                    <q-btn 
                        :loading="submitLoading" 
                        type="submit" 
                        size="md" 
                        color="primary" 
                        class="custom-btn"
                        :class="{ 'full-width': $q.screen.lt.sm }"
                    >Salvar</q-btn>
                </q-card-actions>
            </q-form>
        </q-card-section>
    </q-card>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { emailMsg, requiredMsg, getErrorMessage, minLengthMsg, maxLengthlMsg } from "../../../../helpers/custom-errors";
import useVuelidate from "@vuelidate/core";
import { createUser, getUserById, updateUser } from "../../../../services/userService";
import { useQuasar } from "quasar";
import { UserProps } from "../../../../models/User.model";

export default defineComponent({
    name: "UserFormView",
    mounted() {
        if (this.$route?.params?.id) {
            this.isEditing = true;
            this.loadUser(String(this.$route.params.id));
        }
    },
    setup() {
        const $route = useRoute();
        const $router = useRouter();
        const $q = useQuasar();
        const submitLoading = ref(false);
        const loading = ref(false);
        const isEditing = ref(false);
        const form = ref<UserProps>({
            name: '',
            email: '',
            password: ''
        });
        const rules = computed(() => ({
            form: {
                name: { required: requiredMsg(), maxLength: maxLengthlMsg(100) },
                email: {
                    required: requiredMsg(),
                    email: emailMsg(),
                    maxLength: maxLengthlMsg(50),
                },
                password: { required: requiredMsg(), maxLength: maxLengthlMsg(20), minLength: minLengthMsg(8) },
            }
        }))
        const v$ = useVuelidate(rules, { form });
        const loadUser = async (id: string) => {
            try {
                loading.value = true
                form.value = (await getUserById(id))?.data;
                v$.value.form.$reset();
                setTimeout(() => {
                    console.log(v$.value.$commit)
                }, 2000);
            } catch (error) {

            } finally {
                loading.value = false
            }
        }
        const onSubmit = async () => {
            try {
                submitLoading.value = true;
                isEditing.value ? await updateUser(form.value) : await createUser(form.value);
                $router.push('../users');
                $q.notify({ color: 'positive', message: `Usuário ${isEditing.value ? 'atualizado' : 'adicionado'} com sucesso!` })
            } catch (error: any) {
                console.error(error)
            } finally {
                submitLoading.value = false;
            }
        }
        return {
            form,
            v$,
            onSubmit,
            submitLoading,
            loading,
            $route,
            isEditing,
            loadUser,
            getErrorMessage
        };
    },
});
</script>

<style scoped>
</style>
