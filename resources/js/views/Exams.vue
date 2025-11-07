<template>
  <div>
    <h2 class="text-xl font-semibold">Exams</h2>
    <div class="mt-4">
      <form class="grid grid-cols-2 gap-2" @submit.prevent="create">
        <select v-model="form.patient_id" class="border rounded p-2" required>
          <option value="" disabled>Select patient</option>
          <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
        </select>
        <select v-model="form.doctor_id" class="border rounded p-2">
          <option value="">No doctor</option>
          <option v-for="d in doctors" :key="d.id" :value="d.id">{{ d.name }}</option>
        </select>
        <input v-model="form.type" placeholder="Exam type" class="border rounded p-2" required />
        <input v-model="form.scheduled_date" type="date" class="border rounded p-2" />
        <select v-model="form.status" class="border rounded p-2">
          <option value="pending">Pending</option>
          <option value="scheduled">Scheduled</option>
          <option value="performed">Performed</option>
          <option value="cancelled">Cancelled</option>
        </select>
        <input v-model="form.result" placeholder="Result" class="border rounded p-2 col-span-2" />
        <div class="col-span-2"><button class="px-3 py-2 bg-green-600 text-white rounded">Add</button></div>
      </form>
    </div>
  <div class="mt-4">
    <p v-if="error" class="mb-3 text-red-600">{{ error }}</p>
    <table class="w-full border">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2 text-left">Patient</th>
            <th class="p-2 text-left">Doctor</th>
            <th class="p-2 text-left">Type</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="e in exams" :key="e.id" class="border-t">
            <td class="p-2">{{ nameById(patients, e.patient_id) }}</td>
            <td class="p-2">{{ nameById(doctors, e.doctor_id) }}</td>
            <td class="p-2">{{ e.type }}</td>
            <td class="p-2">{{ e.status }}</td>
            <td class="p-2 text-center">
              <button class="text-red-600" @click="remove(e.id)">Delete</button>
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
const exams = ref([]);
const patients = ref([]);
const doctors = ref([]);
const form = ref({ patient_id: '', doctor_id: '', type: '', scheduled_date: '', status: 'pending', result: '' });
const error = ref(null);

const fetchPatients = async () => {
  error.value = null;
  try { const { data } = await axios.get('/patients'); patients.value = data; }
  catch (e) { error.value = e?.response?.data?.message || 'Failed to load patients'; }
};
const fetchDoctors = async () => {
  error.value = null;
  try { const { data } = await axios.get('/doctors'); doctors.value = data; }
  catch (e) { error.value = e?.response?.data?.message || 'Failed to load doctors'; }
};
const fetchExams = async () => {
  error.value = null;
  try { const { data } = await axios.get('/exams'); exams.value = data; }
  catch (e) { error.value = e?.response?.data?.message || 'Failed to load exams'; }
};

const create = async () => {
  error.value = null;
  try {
    await axios.post('/exams', form.value);
    form.value = { patient_id: '', doctor_id: '', type: '', scheduled_date: '', status: 'pending', result: '' };
    await fetchExams();
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to add exam';
  }
};

const remove = async (id) => {
  error.value = null;
  try { await axios.delete(`/exams/${id}`); await fetchExams(); }
  catch (e) { error.value = e?.response?.data?.message || 'Failed to delete exam'; }
};

const nameById = (arr, id) => arr.find(x => x.id === id)?.name || (id || '-');

onMounted(async () => { await Promise.all([fetchPatients(), fetchDoctors()]); await fetchExams(); });
</script>