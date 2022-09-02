import { email, helpers, required, maxLength, minLength } from "@vuelidate/validators";

export const requiredMsg = (params?: any) => helpers.withMessage('Campo obrigatório', required);
export const emailMsg = (params?: any) => helpers.withMessage('Email inválido', email);
export const minLengthMsg = (params?: any) => helpers.withMessage(`Mínimo de ${params}`, minLength(params));
export const maxLengthlMsg = (params?: any) => helpers.withMessage(`Máximo de ${params}`, maxLength(params));

export const getErrorMessage = (field: any) => field.$silentErrors[0]?.$message