<template>
    <div class="text-h4 q-pb-md">Produtos</div>
    <q-card class="q-pa-sm shadow-10">
        <q-card-section>
            <div class="relative-position">
                <LoadingContainer :loading="loading" />
                <div class="row q-mb-lg">
                    <router-link to="products/create">
                        <q-btn outline color="primary" class="col-12 col-md-3 q-mb-md">
                            <q-icon left size="xs" name="fa-solid fa-plus" />
                            <div>Adicionar</div>
                        </q-btn>
                    </router-link>
                    <q-input 
                        dense
                        :loading="loadingSearch"
                        class="col-12 col-md-4 offset-md-5"
                        @update:modelValue="handleSearch"
                        :debounce="300" 
                        outlined
                        placeholder="Buscar..." 
                        v-model="searchProduct"
                    >
                        <template v-slot:prepend>
                            <q-icon size="xs" name="fa-solid fa-magnifying-glass" />
                        </template>
                    </q-input>
                </div>
                <Table 
                    :dataSorce="products?.data" 
                    :total="products?.total" 
                    :columns="columns" 
                    :actions="actions" 
                    hasIndex
                    hasCheckbox 
                    @onClickedEvent="onAction" 
                    @onPagination="onPagination"
                    @onMultipleSelection="onMultipleSelection" 
                    :loading="paginationLoading" 
                />
            </div>
        </q-card-section>
    </q-card>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import Table from "../../../../components/Table.vue";
import { ProductProps } from "../../../../models/Product.model";
import { deleteAllProducts, deleteProduct, getProducts } from "../../../../services/productService";
import { useQuasar } from "quasar";
import LoadingContainer from "../../../../components/LoadingContainer.vue";
import {
    TableAction,
    TableColumns,
    PaginatorProps,
} from "../../../../models/Table.model";
import { GetResponseProps } from "../../../../models/GetResponse.model";
import { useRouter } from "vue-router";

export default defineComponent({
    name: "ProductList",
    components: { Table, LoadingContainer },
    mounted() {
        this.loadProducts(this.pagination);
    },
    setup() {
        const $q = useQuasar();
        const $router = useRouter();
        const products = ref<GetResponseProps<ProductProps>>();
        const loading = ref(false);
        const loadingSearch = ref(false);
        const paginationLoading = ref(false);
        const searchProduct = ref("");
        const columns = ref<TableColumns[]>([
            {
                name: "name",
                align: "left",
                label: "Nome",
                field: "name",
                sortable: true,
            },
            {
                name: "description",
                align: "left",
                label: "Descrição",
                field: "description",
                sortable: true,
            },
            {
                name: "price",
                align: "left",
                label: "Preço",
                field: "price",
                class: "w-15",
                isInnerHtml: true,
                format: (val) => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(val),
                sortable: true,
            },
        ]);
        const actions = ref<TableAction[]>([
            {
                icon: "fa-solid fa-pen-to-square",
                eventName: "edit",
                color: "secondary",
            },
            { icon: "fa-solid fa-trash", eventName: "delete", color: "warning" },
        ]);
        const pagination = ref<PaginatorProps>({
            descending: false,
            page: 1,
            rowsPerPage: 5,
            rowsNumber: 0,
        });
        const loadProducts = async (
                e?: PaginatorProps, 
                loadingType: 'paginationLoading' | 'loading' = 'loading', 
                search = ""
            ) => {
            try {
                switch (loadingType) {
                    case 'paginationLoading':
                        paginationLoading.value = true;
                        break;                    
                    default:
                        loading.value = true;
                        break;
                }
                if(search) loadingSearch.value = true;
                products.value = (await getProducts(e, search))?.data;
            } finally {
                switch (loadingType) {
                    case 'paginationLoading':
                        paginationLoading.value = false;
                        break;                    
                    default:
                        loading.value = false;
                        break;
                }
                if(search) loadingSearch.value = false;
            }
        };
        const handleDeleteProduct = async(data: any) => {
            try {
                const count = data.length > 1 ? 's' : '';
                loading.value = true;
                await data.length ? deleteAllProducts(data) : deleteProduct((data as any).id);
                $q.notify({
                    type: 'positive',
                    message: `Produto${count} excluído${count} com sucesso!`,
                })
                loadProducts(pagination.value);
            } finally {
                loading.value = false;
            }
        }
        const onAction = (e: any) => {
            switch (e.event) {
                case 'delete':
                    deleteDialog(e.element);
                    break;
                case 'edit':
                    $router.push(`products/${e.element.id}`);
                    break;
                default:
                    break;
            }
        };
        const onPagination = (e: PaginatorProps) => {
            pagination.value = e;
            loadProducts(e, 'paginationLoading');
        };
        const onMultipleSelection = (e: any) => { 
            if(e.event === 'delete') deleteDialog(e.data);
        };
        const handleSearch = (value: any) => { loadProducts(pagination.value, 'paginationLoading', value) };
        const deleteDialog = (data: ProductProps | ProductProps[]) => {
            const count = (data as any).length || 1;
            $q.dialog({
                title: `Excluir produto${count > 1 ? "s" : ""}`,
                message: `Tem certeza que deseja excluir ${count} produto${count > 1 ? "s" : ""}?`,
                cancel: {
                    label: 'Cancelar',
                    color: 'grey-3',
                    textColor: 'grey-10'
                },
                ok: {
                    label: 'Confirmar',
                    color: 'negative'
                },
            }).onOk(() => handleDeleteProduct(data));
        };
        return {
            products,
            loading,
            pagination,
            paginationLoading,
            searchProduct,
            columns,
            actions,
            loadingSearch,
            onAction,
            onPagination,
            onMultipleSelection,
            handleSearch,
            deleteDialog,
            loadProducts,
        };
    },
});
</script>

<style scoped>
</style>
