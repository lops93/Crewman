<template>
  <q-page padding="">
    <q-breadcrumbs-el label="Home" icon="home" class="text-primary"/>
    <div class="q-pa-md">
      <q-table
        title="Employees"
        :rows="employees"
        :columns="columns"
        :filter="filter"
        row-key="name"
        card-class="bg-blue-grey-1 text-blue-grey-9"
        v-model:pagination="pagination"
        hide-pagination
      >
      <template v-slot:top-right>
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:no-data="{}">
        <div class="full-width row flex-center text-accent q-gutter-sm">
          <div>
        <q-spinner-ios
          color="primary"
          size="2em"
        />
        <q-tooltip :offset="[0, 8]">QSpinnerIos</q-tooltip>
      </div>
        </div>
      </template>
      </q-table>
      <div class="row justify-center q-mt-md">
      <q-pagination
        v-model="pagination.page"
        color="primary"
        :max="pagesNumber"
        :max-pages="6"
        size="md"
        direction-links
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
      rowsPerPage: 9
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
