import api from '../api'
import { GetResponseProps } from '../models/GetResponse.model'
import { PaginatorProps } from '../models/Table.model'
import { UserProps } from '../models/User.model'

export const getUsers = (
    e: PaginatorProps = {
        page: 1,
        descending: false,
        rowsPerPage: 10,
        sortBy: 'updated_at',
    },
    search?: string,
) => {
    return api.get<GetResponseProps<UserProps>>(
        `users?page=${e.page}&per_page=${e.rowsPerPage}&orderBy=${e.sortBy ?? 'updated_at'
        }&sort=${e.descending ? 'desc' : 'asc'}${search ? '&search=' + search : ''
        }`,
    )
}

export const getUserById = (id: string) => {
    return api.get<UserProps>(`users/${id}`)
}

export const createUser = (user: UserProps) => {
    return api.post<UserProps>(`users`, user)
}

export const updateUser = (user: UserProps) => {
    return api.put<UserProps>(`users/${user.id}`, user)
}

export const deleteUser = (id: string) => {
    return api.delete<boolean>(`users/${id}`)
}

export const deleteAllUser = (users: UserProps[]) => {
    return api.patch<boolean>(`users/delete`, users)
}
