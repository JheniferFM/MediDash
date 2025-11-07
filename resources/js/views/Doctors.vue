<template>
  <div>
    <h2 class="text-xl font-semibold">Doctors</h2>
    <div class="mt-4">
      <form class="grid grid-cols-2 gap-2" @submit.prevent="create">
        <input v-model="form.name" placeholder="Name" class="border rounded p-2" required />
        <input v-model="form.email" type="email" placeholder="Email" class="border rounded p-2" required />
        <input v-model="form.phone" placeholder="Phone" class="border rounded p-2" />
        <input v-model="form.crm" placeholder="CRM" class="border rounded p-2" />
        <input v-model="form.specialty" placeholder="Specialty" class="border rounded p-2" />
        <div class="col-span-2">
          <button class="px-3 py-2 bg-green-600 text-white rounded">Add</button>
        </div>
      </form>
    </div>
    <div class="mt-4">
      <p v-if="error" class="mb-3 text-red-600">{{ error }}</p>
      <table class="w-full border">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Email</th>
            <th class="p-2 text-left">Phone</th>
            <th class="p-2 text-left">CRM</th>
            <th class="p-2 text-left">Specialty</th>
            <th class="p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="d in doctors" :key="d.id" class="border-t">
            <td class="p-2">{{ d.name }}</td>
            <td class="p-2">{{ d.email }}</td>
            <td class="p-2">{{ d.phone || '-' }}</td>
            <td class="p-2">{{ d.crm || '-' }}</td>
            <td class="p-2">{{ d.specialty || '-' }}</td>
            <td class="p-2 text-center">
              <button class="text-red-600" @click="remove(d.id)">Delete</button>
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
const doctors = ref([]);
const form = ref({ name: '', email: '', phone: '', crm: '', specialty: '' });
const error = ref(null);

const fetchAll = async () => {
  error.value = null;
  try {
    const { data } = await axios.get('/doctors');
    doctors.value = data;
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load doctors';
  }
};

const create = async () => {
  error.value = null;
  try {
    await axios.post('/doctors', form.value);
    form.value = { name: '', email: '', phone: '', crm: '', specialty: '' };
    await fetchAll();
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to add doctor';
  }
};

const remove = async (id) => {
  error.value = null;
  try {
    await axios.delete(`/doctors/${id}`);
    await fetchAll();
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to delete doctor';
  }
};

onMounted(fetchAll);
</script>