<template>
  <div>
    <h2 class="text-xl font-semibold">Prescriptions</h2>
    <div class="mt-4">
      <form class="grid grid-cols-2 gap-2" @submit.prevent="create">
        <select v-model="form.patient_id" class="border rounded p-2" required>
          <option value="" disabled>Select patient</option>
          <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
        </select>
        <select v-model="form.doctor_id" class="border rounded p-2" required>
          <option value="" disabled>Select doctor</option>
          <option v-for="d in doctors" :key="d.id" :value="d.id">{{ d.name }}</option>
        </select>
        <textarea v-model="form.content" placeholder="Prescription content" class="border rounded p-2 col-span-2" rows="3" required></textarea>
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
            <th class="p-2 text-left">Content</th>
            <th class="p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pr in prescriptions" :key="pr.id" class="border-t">
            <td class="p-2">{{ nameById(patients, pr.patient_id) }}</td>
            <td class="p-2">{{ nameById(doctors, pr.doctor_id) }}</td>
            <td class="p-2">{{ pr.content }}</td>
            <td class="p-2 text-center">
              <button class="text-red-600" @click="remove(pr.id)">Delete</button>
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
const prescriptions = ref([]);
const patients = ref([]);
const doctors = ref([]);
const form = ref({ patient_id: '', doctor_id: '', content: '' });
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
const fetchPrescriptions = async () => {
  error.value = null;
  try { const { data } = await axios.get('/prescriptions'); prescriptions.value = data; }
  catch (e) { error.value = e?.response?.data?.message || 'Failed to load prescriptions'; }
};

const create = async () => {
  error.value = null;
  try {
    await axios.post('/prescriptions', form.value);
    form.value = { patient_id: '', doctor_id: '', content: '' };
    await fetchPrescriptions();
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to add prescription';
  }
};

const remove = async (id) => {
  error.value = null;
  try { await axios.delete(`/prescriptions/${id}`); await fetchPrescriptions(); }
  catch (e) { error.value = e?.response?.data?.message || 'Failed to delete prescription'; }
};

const nameById = (arr, id) => arr.find(x => x.id === id)?.name || (id || '-');

onMounted(async () => { await Promise.all([fetchPatients(), fetchDoctors()]); await fetchPrescriptions(); });
</script>