<template>
    <div class="text-h4 q-pb-md" :class="{ 'text-center' : $q.screen.lt.sm }">Usuários</div>
    <div :class="{ 'q-card q-pa-sm shadow-10' : $q.screen.gt.xs, 'bg-dark' : $q.screen.gt.xs && $q.dark.isActive }">
        <div :class="{ 'q-card__section q-card__section--vert' : $q.screen.gt.xs }">
            <div class="relative-position">
                <!-- <LoadingContainer :loading="loading" /> -->
                <div class="row q-mb-lg">
                    <router-link to="users/create" class="col-12 col-md-3 q-mb-md">
                        <q-btn :outline="$q.screen.gt.xs" color="primary" class="full-width">
                            <q-icon left size="xs" name="fa-solid fa-plus" />
                            <div>Adicionar</div>
                        </q-btn>
                    </router-link>
                    <q-input 
                        dense
                        type="search"
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
                    :loading="loading" 
                />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from "vue";
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
import { useRouter } from "vue-router";
import { useUserStore } from "../../../../store/user";

export default defineComponent({
    name: "UserList",
    components: { Table, LoadingContainer },
    mounted() {
        this.loadUsers(this.pagination);
    },
    setup() {
        const $q = useQuasar();
        const userStore = useUserStore();
        const $router = useRouter();
        // const users = ref<GetResponseProps<UserProps>>();
        // const loading = ref(false);
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
                color: "info",
            },
            { icon: "fa-solid fa-trash", eventName: "delete", color: "warning" },
        ]);
        const pagination = ref<PaginatorProps>({
            descending: false,
            page: 1,
            rowsPerPage: 5,
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
                        // loading.value = true;
                        break;
                }
                if(search) loadingSearch.value = true;
                const data = await userStore.getUsers(e, search);
                userStore.setUsers(data);
                // users.value = (await getUsers(e, search))?.data;
            } finally {
                switch (loadingType) {
                    case 'paginationLoading':
                        paginationLoading.value = false;
                        break;                    
                    default:
                        // loading.value = false;
                        break;
                }
                if(search) loadingSearch.value = false;
            }
        };
        const handleDeleteUser = async(data: any) => {
            try {
                const count = data.length > 1 ? 's' : '';
                // loading.value = true;
                await data.length ? deleteAllUser(data) : deleteUser((data as any).id);
                $q.notify({
                    type: 'positive',
                    message: `Usuario${count} excluído${count} com sucesso!`,
                    position: window.innerWidth <= 600 ? 'top' : 'top-right',
                    classes: window.innerWidth <= 600 ? 'full-width' : '',
                })
                loadUsers(pagination.value);
            } finally {
                // loading.value = false;
            }
        }
        const onAction = (e: any) => {
            switch (e.event) {
                case 'delete':
                    deleteDialog(e.element);
                    break;
                case 'edit':
                    $router.push(`users/${e.element.id}`);
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
                    textColor: $q.dark.isActive ? 'white' : 'grey-10',
                    color: $q.dark.isActive ? 'secondary' : 'grey-3',
                },
                ok: {
                    label: 'Confirmar',
                    color: 'negative'
                },
                class: 'pb-2 px-1'
            }).onOk(() => handleDeleteUser(data));
        };
        return {
            users: computed(() => userStore.data),
            loading: computed(() => userStore.loading),
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
