import api from '../api'

const options = { headers: { "Content-Type": "multipart/form-data" } }

export const createAvatar = (image: FormData) => {
    return api.post<FormData>(`avatars`, image, options)
}

export const updateAvatar = (id: string, image: FormData) => {
    return api.put<FormData>(`avatars/${id}`, image, options)
}

export const deleteAvatar = (id: string) => {
    return api.delete<boolean>(`avatars/${id}`)
}
