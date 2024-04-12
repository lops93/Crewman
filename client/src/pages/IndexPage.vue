<template>
  <q-page padding="">
    <div class="q-pa-md">
      <q-table
        title="Employees"
        :rows="employees"
        :columns="columns"
        row-key="name"
        v-model:pagination="pagination"
        hide-pagination
      />
      <div class="row justify-center q-mt-md">
      <q-pagination
        v-model="pagination.page"
        color="grey-8"
        :max="pagesNumber"
        size="sm"
      />
    </div>
    </div>
  </q-page>
</template>

<script>
import { onMounted, ref, computed } from 'vue'
import { api } from 'boot/axios'

export default {
  name: 'IndexPage',
  setup () {
    const employees = ref([])
    const columns = [
      { name: 'identification_number', align: 'left', label: 'ID', field: 'identification_number', sortable: true },
      { name: 'first_name', align: 'left', label: 'First Name', field: 'first_name', sortable: true },
      { name: 'last_name', align: 'left', label: 'Last Name', field: 'last_name', sortable: true }
    ]
    const pagination = ref({
      sortBy: 'desc',
      descending: false,
      page: 2,
      rowsPerPage: 10
    })
    onMounted(() => {
      getPosts()
    })

    const getPosts = async () => {
      try {
        const { data } = await api.get('employees')
        employees.value = data
      } catch (error) {
        console.log(error)
      }
    }
    const pagesNumber = computed(() => employees.value.length / pagination.value.rowsPerPage)

    return {
      employees,
      columns,
      pagination,
      pagesNumber
    }
  }
}
</script>
