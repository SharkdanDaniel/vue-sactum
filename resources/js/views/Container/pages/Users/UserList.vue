<template>
    <div class="text-h4 q-pb-md">Usuários</div>
    <q-card class="q-pa-sm shadow-10">
        <q-card-section>
            <div class="relative-position">
                <LoadingContainer :loading="loading" />
                <div class="row q-mb-lg">
                    <q-btn outline color="primary" class="col-12 col-md-3 q-mb-md">
                        <q-icon left size="xs" name="fa-solid fa-plus" />
                        <div>Adicionar</div>
                    </q-btn>
                    <q-input 
                        dense
                        :loading="loadingSearch"
                        class="col-12 col-md-4 offset-md-5"
                        @update:modelValue="handleSearch"
                        :debounce="300" 
                        outlined
                        placeholder="Buscar..." 
                        v-model="searchUser"
                    >
                        <template v-slot:prepend>
                            <q-icon size="xs" name="fa-solid fa-magnifying-glass" />
                        </template>
                    </q-input>
                </div>
                <Table 
                    :dataSorce="users?.data" 
                    :total="users?.total" 
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
import { UserProps } from "../../../../models/User.model";
import { deleteAllUser, deleteUser, getUsers } from "../../../../services/userService";
import { useQuasar } from "quasar";
import LoadingContainer from "../../../../components/LoadingContainer.vue";
import {
    TableAction,
    TableColumns,
    PaginatorProps,
} from "../../../../models/Table.model";
import { GetResponseProps } from "../../../../models/GetResponse.model";

export default defineComponent({
    name: "UserList",
    components: { Table, LoadingContainer },
    mounted() {
        this.loadUsers(this.pagination);
    },
    setup() {
        const $q = useQuasar();
        const users = ref<GetResponseProps<UserProps>>();
        const loading = ref(false);
        const loadingSearch = ref(false);
        const paginationLoading = ref(false);
        const searchUser = ref("");
        const columns = ref<TableColumns[]>([
            {
                name: "name",
                align: "left",
                label: "Nome",
                field: "name",
                sortable: true,
            },
            {
                name: "email",
                align: "left",
                label: "Email",
                field: "email",
                class: "w-30",
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
            rowsPerPage: 10,
            rowsNumber: 0,
        });
        const loadUsers = async (
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
                users.value = (await getUsers(e, search))?.data;
            } catch (error) {
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
        const handleDeleteUser = async(data: any) => {
            try {
                const count = data.length > 1 ? 's' : '';
                loading.value = true;
                await data.length ? deleteAllUser(data) : deleteUser((data as any).id);
                $q.notify({
                    type: 'positive',
                    message: `Usuario${count} excluído${count} com sucesso!`,
                })
                loadUsers(pagination.value);
            } catch (error) {
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
                    break;
                default:
                    break;
            }
        };
        const onPagination = (e: PaginatorProps) => {
            pagination.value = e;
            loadUsers(e, 'paginationLoading');
        };
        const onMultipleSelection = (e: any) => { 
            if(e.event === 'delete') deleteDialog(e.data);
        };
        const handleSearch = (value: any) => { loadUsers(pagination.value, 'paginationLoading', value) };
        const deleteDialog = (data: UserProps | UserProps[]) => {
            const count = (data as any).length || 1;
            $q.dialog({
                title: `Excluir usuario${count > 1 ? "s" : ""}`,
                message: `Tem certeza que deseja excluir ${count} usuario${count > 1 ? "s" : ""}?`,
                cancel: {
                    label: 'Cancelar',
                    color: 'grey-3',
                    textColor: 'grey-10'
                },
                ok: {
                    label: 'Confirmar',
                    color: 'negative'
                },
            }).onOk(() => handleDeleteUser(data));
        };
        return {
            users,
            loading,
            pagination,
            paginationLoading,
            searchUser,
            columns,
            actions,
            loadingSearch,
            onAction,
            onPagination,
            onMultipleSelection,
            handleSearch,
            deleteDialog,
            loadUsers,
        };
    },
});
</script>

<style scoped>
</style>
