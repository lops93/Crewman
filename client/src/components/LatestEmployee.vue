<template>
  <div class="q-mb-sm">
      <q-banner class="bg-blue-grey-1 text-blue-grey-9">
      <template v-slot:avatar>
        <q-icon name="portrait" color="primary" />
      </template>
        <p class="text-overline q-mb-sm">Most Recent Employer</p>
        <h6 class="q-my-sm">{{ employee.first_name }} {{ employee.last_name }} </h6>
        <p class="text-subtitle2">{{ employee.identification_number }} </p>
    </q-banner>
    </div>
</template>

<script>
import { onMounted, ref } from 'vue'
import { api } from 'boot/axios'

export default {
  name: 'LatestEmployee',
  setup () {
    const employee = ref([])

    onMounted(() => {
      getLatestEmployee()
    })

    const getLatestEmployee = async () => {
      try {
        const { data } = await api.get('employee/last')
        employee.value = data
      } catch (error) {
        console.log(error)
      }
    }

    return {
      employee
    }
  }
}
</script>
