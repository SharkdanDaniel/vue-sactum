<template>
    <DarkToggle />
    <div class="row justify-center items-center full-height position-relative">
        <div class="login-card" :class="{ 'q-card q-pa-md shadow-10 q-card--bordered' : $q.screen.gt.xs, 'bg-dark' : $q.screen.gt.xs && $q.dark.isActive }">
            <q-card-section>
                <div class="row items-center no-wrap q-pa-md">
                    <div class="col">
                        <div class="text-h3 text-center">Login</div>
                    </div>
                </div>
            </q-card-section>
            
            <q-card-section>
                <q-form @submit.prevent="onSubmit">
                    <div class="q-mb-md">
                        <q-input 
                            ref="inputRef" 
                            type="email" 
                            v-model="form.email" 
                            label="Email" 
                            outlined
                            :rules="[() => getErrorMessage(v$.form.email) ]" 
                            dense 
                        />
                    </div>
                    <div class="q-mb-md">
                        <q-input 
                            ref="inputRef" 
                            type="password" 
                            v-model="form.password" 
                            label="Senha" 
                            outlined
                            :rules="[() => getErrorMessage(v$.form.password) ]" 
                            dense 
                        />
                    </div>

                    <q-card-actions class="q-pa-none">
                        <q-btn :loading="loading" type="submit" size="lg" color="primary" class="full-width">ENTRAR</q-btn>
                    </q-card-actions>
                </q-form>
            </q-card-section>
        </div>
    </div>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from 'vue';
import { onLogin, setAuth } from '../services/authService';
import { requiredMsg, emailMsg, getErrorMessage } from '../helpers/custom-errors';
import { useQuasar } from 'quasar';
import { useRouter } from 'vue-router';
import useVuelidate from '@vuelidate/core'
import DarkToggle from '../components/DarkToggle.vue';
import { useAuthStore } from '../store/auth';

type FormProps = {
    email: string;
    password: string;
}

export default defineComponent({
    name: "LoginView",
    components: { DarkToggle },
    setup() {
        const authStore = useAuthStore();
        const $q = useQuasar();
        const $router = useRouter();
        const form = ref<FormProps>({
            email: "",
            password: ""
        });
        const rules = computed(() => ({
            form: {
                email: {
                    required: requiredMsg(),
                    email: emailMsg(),
                    $anyDirty: false
                },
                password: { required: requiredMsg() },
            }
        }));
        const v$ = useVuelidate(rules, { form });
        const onSubmit = async () => {
            try {
                await authStore.onLogin(form.value);
                $router.push("/");
            } catch(err) {
                throw err;
            }
            
        };
        return {
            form,
            v$,
            onSubmit,
            getErrorMessage,
            loading: computed(() => authStore.loading)
        };
    },
})
</script>

<style lang="scss" scoped>
.login-card {
    width: 100%;
    max-width: 500px;
}
.q-toggle {
    position: absolute;
}
</style>