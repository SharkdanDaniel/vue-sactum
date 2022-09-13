<template>
    <q-input 
        ref="inputRef" 
        v-model="value" 
        dense 
        outlined 
        :label="label"
        :rules="() => rules"
    />
</template>
  
<script lang="ts">
import { useCurrencyInput } from "vue-currency-input";

export default {
    name: "CurrencyInputComponent",
    props: {
        modelValue: Number,
        rules: Array,
        label: String
    },
    setup(props: any) {
        const { inputRef } = useCurrencyInput({ currency: 'BRL' });
        return { inputRef };
    },
};
</script>
  