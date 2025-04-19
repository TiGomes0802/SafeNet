import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
//import { Toaster } from '@/components/ui/sonner'

export const useErrorStore = defineStore('error', () => {
    //const { toast } = Toaster()
    const _message = ref('');
    const _fieldErrorMessages = ref([]);
    const _statusCode = ref(0)
    const _title = ref('')

    const message = computed(() => _message.value.trim())
    const statusCode = computed(() => _statusCode.value)
    const title = computed(() => _title.value.trim())

    const fieldMessage = (fieldName) => {
        const errorsOfField = _fieldErrorMessages.value ? _fieldErrorMessages.value[fieldName] : ''
        return errorsOfField ? errorsOfField[0] : '';
    }

    const resetMessages = () => {
        _message.value = ''
        _fieldErrorMessages.value = []
        _statusCode.value = 0
        _title.value = ''
    }

    const setErrorMessages = (mainMessage, fieldMessages, status = 0, titleMessage = '') => {
        _message.value = mainMessage
        _fieldErrorMessages.value = fieldMessages
        _statusCode.value = status
        _title.value = titleMessage

        let toastMessage = mainMessage
        switch (status) {
            case 401:
                toastMessage = 'Não estás autorizado a aceder à API do servidor!'
                break
            case 403:
                toastMessage = 'Não tens permissão para aceder ao recurso do servidor!'
                break
            case 404:
                toastMessage = 'Recurso do servidor não encontrado!'
                break
            case 422:
                toastMessage = 'Os dados são inválidos. Verifica os erros nos campos!'
                break
            default:
                toastMessage = `Ocorreu um erro! Mensagem do servidor: "${mainMessage}"`
        }

        console.log(`Error ${status} - ${toastMessage}`)

        /*toast({
            title: titleMessage || 'Erro',
            description: toastMessage,
            variant: 'destructive'
        })*/
    }

    return {
        message, statusCode, title,
        fieldMessage, resetMessages, setErrorMessages
    }
})
