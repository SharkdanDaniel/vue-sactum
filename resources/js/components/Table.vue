<template>
    <q-table 
        :dense="$q.screen.lt.md" 
        :grid="$q.screen.lt.sm" 
        :rows="dataSorce"
        :card-class="$q.screen.lt.sm ? 'shadow-10' : ''" 
        flat 
        bordered 
        :columns="columns" 
        color="primary"
        row-key="id" 
        :rows-per-page-options="[3, 5, 7, 10]" 
        rows-per-page-label="Itens por página"
        :no-data-label="emptyMessage" 
        v-model:pagination="pagination"
        v-model:selected="selected"
        :selection="hasCheckbox ? 'multiple' : 'none'"
        top
        :selected-rows-label="getSelectedLabel"
        :pagination-label="getPaginationLabel"
        :loading="loading"
        @request="onRequest"
    >
        <template v-slot:top>
            <div class="row justify-end q-px-xs full-width" style="gap: 5px" v-if="selected.length">
                <q-btn
                    v-for="button in selectedButtons" 
                    :key="button.icon"
                    :color="button.color"
                    size="md"
                    :icon="button.icon"
                    @click="$emit('onMultipleSelection', { event: button.event, data: selected })"
                />
            </div>
        </template>
        <template v-slot:item="props">
            <q-card 
                class="full-width shadow-10 mb-4 pb-5" 
                :class="{ 
                    'bg-blue-grey-2' : props.selected && !$q.dark.isActive, 
                    'bg-blue-grey-9' : props.selected && $q.dark.isActive
                }"
            >
                <template v-if="hasCheckbox || hasIndex || actions.length">
                    <q-card-section class="row justify-between">
                        <div>
                            <q-checkbox v-if="hasCheckbox" dense v-model="props.selected" class="mr-4" />
                            <q-label class="font-bold" v-if="hasIndex">{{ props.rowIndex + 1 }}</q-label>
                        </div>
                    </q-card-section>
                    <q-separator />
                </template>                
                <q-list>
                    <q-item v-for="col in props.cols.filter((col) => col.name !== 'actions' && col.name !== 'index')" :key="col.name">
                        <q-item-section>
                            <q-item-label>{{ col.label }}</q-item-label>
                            <q-item-label caption>{{ col.value }}</q-item-label>
                        </q-item-section>                        
                    </q-item>
                </q-list>
                <div class="row justify-center">
                    <q-btn
                        v-for="action in actions" :key="action.icon"
                        class="q-mr-sm q-pa-sm" 
                        size="xs" 
                        :color="action.color" 
                        :class="action.class" 
                        :icon="action.icon"
                        @click="$emit('onClickedEvent', { element: props.row, event: action.eventName })" 
                    />
                </div>
            </q-card>
        </template>
        <template v-slot:body-cell-index="props" v-if="hasIndex">
            <q-td :props="props">{{ props.rowIndex + 1 }}</q-td>
        </template>
        <template v-slot:body-cell="props">
            <q-td :props="props" v-if="props.col.isInnerHtml" v-html="props.value" />
            <q-td :props="props" v-else :class="props.col.class">
                {{ props.value }}
            </q-td>
        </template>
        <template v-slot:body-cell-actions="props">
            <q-td :props="props" class="w-15">
                <template v-for="action in actions" :key="action.icon">
                    <q-btn 
                        class="q-mr-sm q-pa-sm" 
                        size="xs" 
                        :color="action.color" 
                        :class="action.class" 
                        :icon="action.icon"
                        @click="$emit('onClickedEvent', { element: props.row, event: action.eventName })" 
                    />
                </template>
            </q-td>
        </template>
    </q-table>
</template>

<script lang="ts">
import { computed } from "@vue/reactivity";
import { QTableProps, useQuasar } from "quasar";
import { defineComponent, PropType, ref } from "vue";
import { PaginatorProps, TableAction, TableColumns } from "../models/Table.model";

export default defineComponent({
    name: "TableComponent",
    emits: ["onClickedEvent", "onPagination", "onMultipleSelection"],
    props: {
        dataSorce: { type: Array as PropType<any[]>, required: true, default: [] },
        total: { type: Number, required: true, default: 0 },
        selectedButtons: { type: Array as PropType<any[]>, default: [{ color: 'red', icon: 'fa-solid fa-trash', event: 'delete' }] },
        columns: { type: Array as PropType<TableColumns[] | any>, required: true, default: [] },
        actions: { type: Array as PropType<TableAction[]>, default: [] },
        emptyMessage: { type: String, default: "Nenhum item encontrado!" },
        loading: { type: Boolean, default: false },
        hasIndex: { type: Boolean, default: false },
        hasCheckbox: { type: Boolean, default: false },        
    },
    beforeUpdate() {
        (this.pagination as any).rowsNumber = this.total;
    },
    data() {
        return {};
    },
    mounted() {
        this.columns.push({ name: "actions", align: "right", label: "" });
        if(this.hasIndex) this.columns.unshift({ name: "index", align: "left", label: "#" });
    },    
    setup(props, { emit }) {
        const onRequest = ref((e: any) => {
            pagination.value = e.pagination;
            emit('onPagination', e.pagination)
        })
        const selected = ref([]);
        const getPaginationLabel = (firstRowIndex: number, endRowIndex: number, totalRowsNumber: number) => {
            return `${firstRowIndex}-${endRowIndex} de ${totalRowsNumber}`;
        }
        const getSelectedLabel = () => {
            return selected.value.length === 0 ? '' : `${selected.value.length} registro${selected.value.length > 1 ? 's' : ''} selecionado${selected.value.length > 1 ? 's' : ''}`
      }
        const pagination = ref<PaginatorProps>({
            descending: false,
            page: 1,
            rowsPerPage: 5,
            rowsNumber: props.total
        })
        return {
            pagination,
            onRequest,
            selected,
            getSelectedLabel,
            getPaginationLabel,
            selectionButtons: computed(() => props.selectedButtons)
        };
    },
});
</script>


<style lang="scss">
    .w-10 {
        width: 10%;
    }
    .w-15 {
        width: 15%;
    }
    .w-20 {
        width: 20%;
    }
    .w-30 {
        width: 30%;
    }
    .w-40 {
        width: 40%;
    }
    .w-40 {
        width: 40%;
    }
    .w-50 {
        width: 50%;
    }
    .w-60 {
        width: 60%;
    }
    .w-70 {
        width: 70%;
    }
    .w-80 {
        width: 80%;
    }
    .w-90 {
        width: 90%;
    }
</style>