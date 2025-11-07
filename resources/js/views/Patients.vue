<template>
  <div>
    <h2 class="text-xl font-semibold">Patients</h2>
    <div class="mt-4">
      <form class="flex gap-2" @submit.prevent="create">
        <input v-model="form.name" placeholder="Name" class="border rounded p-2" required />
        <input v-model="form.email" type="email" placeholder="Email" class="border rounded p-2" required />
        <input v-model="form.phone" placeholder="Phone" class="border rounded p-2" />
        <button class="px-3 py-2 bg-green-600 text-white rounded">Add</button>
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
            <th class="p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="p in patients" :key="p.id" class="border-t">
            <td class="p-2">{{ p.name }}</td>
            <td class="p-2">{{ p.email }}</td>
            <td class="p-2">{{ p.phone || '-' }}</td>
            <td class="p-2 text-center">
              <button class="text-red-600" @click="remove(p.id)">Delete</button>
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
const patients = ref([]);
const form = ref({ name: '', email: '', phone: '' });
const error = ref(null);

const fetchAll = async () => {
  error.value = null;
  try {
    const { data } = await axios.get('/patients');
    patients.value = data;
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to load patients';
  }
};

const create = async () => {
  error.value = null;
  try {
    await axios.post('/patients', form.value);
    form.value = { name: '', email: '', phone: '' };
    await fetchAll();
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to add patient';
  }
};

const remove = async (id) => {
  error.value = null;
  try {
    await axios.delete(`/patients/${id}`);
    await fetchAll();
  } catch (e) {
    error.value = e?.response?.data?.message || 'Failed to delete patient';
  }
};

onMounted(fetchAll);
</script>