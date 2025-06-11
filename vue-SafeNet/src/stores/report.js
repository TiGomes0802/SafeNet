import { ref } from 'vue'
import { defineStore} from 'pinia'
import axios from 'axios'
import { useErrorStore } from "@/stores/error";

export const useReportStore = defineStore('report', () => {
    const storeError = useErrorStore();
    
    const reports = ref([])
    const report = ref(null)

    const getReports = async () => {
        try {
            const response = await axios.get("reports");
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

    const updateEstadoReport = async (idReport) => {
        try {
            const response = await axios.put("report/" + idReport + "/estado");
            if (response.status === 200) {
                report.value = response.data.estado;
                await getReports(); // Refresh the reports list
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
        getReports,
        reportarJogo,
        updateEstadoReport
    }
})