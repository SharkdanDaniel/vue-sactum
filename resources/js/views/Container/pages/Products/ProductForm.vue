<template>
    <div class="text-h4 q-pb-md" :class="{ 'text-center' : $q.screen.lt.sm }">{{ isEditing ? 'Editar' : 'Adicionar' }} produto</div>
    <div :class="{ 'q-card q-pa-sm shadow-10' : $q.screen.gt.xs }">
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
                        v-model="form.name" 
                        label="Nome" 
                        dense 
                        outlined
                        :rules="[() => getErrorMessage(v$.form.name)]" 
                    />
                </div>
                <div class="mb-5">
                    <!-- <q-field
                        v-model="form.price"
                        label="Preço"
                        type="text"
                        dense
                        outlined
                        :rules="[() => getErrorMessage(v$.form.price)]"
                    >
                        <template v-slot:control="{ id, floatingLabel, modelValue, emitValue }">
                            <input
                                :ref="inputRef"
                                :id="id"
                                class="q-field__input"
                                :value="modelValue"
                                @change="e => emitValue(e?.target?.value)"
                                v-show="floatingLabel" 
                            />
                        </template>
                    </q-field> -->
                    <!-- <CurrencyInput 
                        v-model="form.price"
                        label="Preço"
                        :rules="[() => getErrorMessage(v$.form.price)]"
                    /> -->
                    <q-input
                        :ref="inputRef"
                        v-model="form.price"
                        type="number"
                        label="Preço"
                        dense 
                        outlined
                        :rules="[() => getErrorMessage(v$.form.price)]"
                    />
                </div>
                <div class="mb-5">
                    <q-input 
                        v-model="form.description" 
                        label="Descrição" 
                        dense 
                        outlined
                        :rules="[() => getErrorMessage(v$.form.description)]" 
                    />
                </div>
                <q-card-actions class="q-pa-none" style="gap: 10px" :class="$q.screen.lt.sm ? 'column' : 'justify-end'">
                    <router-link to="../products" :class="{ 'full-width': $q.screen.lt.sm }">
                        <q-btn 
                            :disable="submitLoading" 
                            type="button" 
                            size="md" 
                            :text-color="$q.dark.isActive ? 'white' : 'grey-10'"
                            :color="$q.dark.isActive ? 'secondary' : 'grey-1'"
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
    </div>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { requiredMsg, getErrorMessage, maxLengthlMsg } from "../../../../helpers/custom-errors";
import useVuelidate from "@vuelidate/core";
import { createProduct, getProductById, updateProduct } from "../../../../services/productService";
import { useQuasar } from "quasar";
import { ProductProps } from "../../../../models/Product.model";
import { useCurrencyInput } from "vue-currency-input";
import CurrencyInput from "../../../../components/CurrencyInput.vue";


export default defineComponent({
    name: "ProductFormView",
    components: { CurrencyInput },
    mounted() {
        if (this.$route?.params?.id) {
            this.isEditing = true;
            this.loadProduct(String(this.$route.params.id));
        }
    },
    setup() {
        const $route = useRoute();
        const $router = useRouter();
        const { inputRef } = useCurrencyInput({ currency: 'BRL' });
        const moneyFormatForComponent = ref({
            decimal: ',',
            thousands: '.',
            prefix: 'R$ ',
            suffix: ' #',
            precision: 2,
            masked: true
        })
        const $q = useQuasar();
        const submitLoading = ref(false);
        const loading = ref(false);
        const isEditing = ref(false);
        const form = ref<ProductProps>({
            name: '',
            price: null!,
            description: ''
        });
        const rules = computed(() => ({
            form: {
                name: { required: requiredMsg(), maxLength: maxLengthlMsg(100) },
                price: { required: requiredMsg() },
                description: { required: requiredMsg(), maxLength: maxLengthlMsg(100) },
            }
        }))
        const v$ = useVuelidate(rules, { form });
        const loadProduct = async (id: string) => {
            try {
                loading.value = true
                form.value = (await getProductById(id))?.data;
                v$.value.form.$reset();
            } finally {
                loading.value = false
            }
        }
        const onSubmit = async () => {
            try {
                submitLoading.value = true;
                // const result = { ...form.value };
                // result.price = Number(result.price?.toString()?.replace(',', '.'));
                isEditing.value ? await updateProduct(form.value) : await createProduct(form.value);
                $router.push('../products');
                $q.notify({ 
                    color: 'positive', 
                    message: `Producto ${isEditing.value ? 'atualizado' : 'adicionado'} com sucesso!`,
                    position: window.innerWidth <= 600 ? 'top' : 'top-right',
                    classes: window.innerWidth <= 600 ? 'full-width' : '',
                })
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
            inputRef,
            isEditing,
            loadProduct,
            moneyFormatForComponent,
            getErrorMessage
        };
    },
});
</script>

<style scoped>
</style>
