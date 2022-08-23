<template>
    <div class="row justify-center items-center full-height">
        <q-card flat bordered class="login-card q-pa-md">
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
                        <q-input ref="inputRef" type="email" v-model="form.email" label="Email" outlined
                            :rules="[val => !!val || 'Field is required']" />
                    </div>
                    <div class="q-mb-md">
                        <q-input ref="inputRef" type="password" v-model="form.password" label="Senha" outlined
                            :rules="[val => !!val || 'Field is required']" />
                    </div>

                    <q-card-actions class="">
                        <q-btn :loading="loading" type="submit" size="lg" color="primary" class="full-width">ENTRAR
                        </q-btn>
                    </q-card-actions>
                </q-form>
            </q-card-section>
        </q-card>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { onLogin, setAuth } from '../services/authService';
import { useQuasar } from 'quasar';
import { useRouter } from 'vue-router';

type FormProps = {
    email: string;
    password: string;
}

export default defineComponent({
    name: 'LoginView',
    setup() {
        const $q = useQuasar();
        const $router = useRouter();

        const loading = ref(false);

        const form = ref<FormProps>({
            email: '',
            password: ''
        });

        const onSubmit = async () => {
            try {
                loading.value = true;
                const { data } = await onLogin(form.value);
                setAuth(data);
                $router.push('/');
            } catch (error: any) {
                console.error(error)
                $q.notify({ type: 'negative', message: error?.response?.data?.message || 'Erro ao realizar o login!' });
            } finally {
                loading.value = false;
            }
        }

        return {
            form,
            onSubmit,
            loading
        }
    }
})
</script>

<style lang="scss" scoped>
.login-card {
    width: 500px;
}
</style>