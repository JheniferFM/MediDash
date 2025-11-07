<template>
  <div>
    <h2 class="text-xl font-semibold">Consultas</h2>
    <div class="mt-4">
      <form class="grid grid-cols-2 gap-2" @submit.prevent="create">
        <select v-model="form.patient_id" class="border rounded p-2" required>
          <option value="" disabled>Selecione o paciente</option>
          <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
        </select>
        <select v-model="form.doctor_id" class="border rounded p-2" required>
          <option value="" disabled>Selecione o médico</option>
          <option v-for="d in doctors" :key="d.id" :value="d.id">{{ d.name }}</option>
        </select>
        <input v-model="form.scheduled_at" type="datetime-local" class="border rounded p-2" required />
        <select v-model="form.status" class="border rounded p-2">
          <option value="scheduled">Agendada</option>
          <option value="completed">Concluída</option>
          <option value="cancelled">Cancelada</option>
        </select>
        <input v-model="form.notes" placeholder="Notas" class="border rounded p-2 col-span-2" />
        <div class="col-span-2"><button class="px-3 py-2 bg-green-600 text-white rounded">Agendar</button></div>
      </form>
    </div>
  <div class="mt-4">
    <p v-if="error" class="mb-3 text-red-600">{{ error }}</p>
    <table class="w-full border">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2 text-left">Paciente</th>
            <th class="p-2 text-left">Médico</th>
            <th class="p-2 text-left">Data/Hora</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="a in appointments" :key="a.id" class="border-t">
            <td class="p-2">{{ nameById(patients, a.patient_id) }}</td>
            <td class="p-2">{{ nameById(doctors, a.doctor_id) }}</td>
            <td class="p-2">{{ formatDateTime(a.scheduled_at) }}</td>
            <td class="p-2">{{ a.status }}</td>
            <td class="p-2 text-center">
              <button class="text-red-600" @click="remove(a.id)">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
const appointments = ref([]);
const patients = ref([]);
const doctors = ref([]);
const form = ref({ patient_id: '', doctor_id: '', scheduled_at: '', status: 'scheduled', notes: '' });
const error = ref(null);

const fetchPatients = async () => {
  error.value = null;
  try { const { data } = await axios.get('/patients'); patients.value = data; }
  catch (e) { error.value = e?.response?.data?.message || 'Falha ao carregar pacientes'; }
};
const fetchDoctors = async () => {
  error.value = null;
  try { const { data } = await axios.get('/doctors'); doctors.value = data; }
  catch (e) { error.value = e?.response?.data?.message || 'Falha ao carregar médicos'; }
};
const fetchAppointments = async () => {
  error.value = null;
  try { const { data } = await axios.get('/appointments'); appointments.value = data; }
  catch (e) { error.value = e?.response?.data?.message || 'Falha ao carregar consultas'; }
};

const create = async () => {
  error.value = null;
  try {
    const payload = { ...form.value };
    if (payload.scheduled_at) { payload.scheduled_at = payload.scheduled_at.replace('T', ' ') + ':00'; }
    await axios.post('/appointments', payload);
    form.value = { patient_id: '', doctor_id: '', scheduled_at: '', status: 'scheduled', notes: '' };
    await fetchAppointments();
  } catch (e) {
    error.value = e?.response?.data?.message || 'Falha ao agendar consulta';
  }
};

const remove = async (id) => {
  error.value = null;
  try { await axios.delete(`/appointments/${id}`); await fetchAppointments(); }
  catch (e) { error.value = e?.response?.data?.message || 'Falha ao excluir consulta'; }
};

const nameById = (arr, id) => arr.find(x => x.id === id)?.name || id;
const formatDateTime = (dt) => new Date(dt).toLocaleString();

onMounted(async () => { await Promise.all([fetchPatients(), fetchDoctors()]); await fetchAppointments(); });
</script>