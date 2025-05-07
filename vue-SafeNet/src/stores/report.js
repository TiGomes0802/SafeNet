import { ref } from 'vue'
import { defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";
import { useRouter } from 'vue-router'

export const useReportStore = defineStore('report', () => {
    const router = useRouter()
    const storeError = useErrorStore();
    
    const reports = ref([])
    const report = ref(null)

    const getReport = async (idJogo) => {
        try {
            const response = await axios.get("report/report/" + idJogo);
            report.value = response.data;
            return true;
        }
        catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error fetching report!"
            );
            return false;
        }
    }

    const getReports = async () => {
        try {
            const response = await axios.get("report/getReports");
            reports.value = response.data;
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error fetching reports!"
            );
            return false;
        }
    }

    const reportarJogo = async (idJogo, mensagem) => {
        try {
            const report = {
                mensagem: mensagem,
                idJogo: idJogo
            }
            console.log(report);
            const response = await axios.post("report", report);
            reports.value.push(response.data);
            return true;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error creating report!"
            );
            return false;
        }
    }

    const updateEstadoReport = async (idJogo) => {
        try {
            const response = await axios.put("report/" + idJogo + "/estado");
            if (response.status === 200) {
                report.value = response.data.estado;
                return true;
            }
            return false;
        } catch (e) {
            storeError.setErrorMessages(
                e.response.data.message,
                e.response.data.errors,
                e.response.status,
                "Error updating report!"
            );
            return false;
        }
    }

    return{
        reports,
        getReport,
        getReports,
        reportarJogo,
        updateEstadoReport
    }
})