<template>
  <q-page padding>
    <q-breadcrumbs-el label="Home" icon="home" class="text-primary"/>
    <div class="q-pa-md">
      <LatestEmployee />
      <q-table
        title="Employees"
        :rows="employees"
        :columns="columns"
        :filter="filter"
        no-data-label="loading..."
        row-key="name"
        card-class="bg-blue-grey-1 text-blue-grey-9"
      >
      <template v-slot:top-right>
        <q-btn outline color="primary" label="Add Employee" class="q-mr-md" :to="{ name: 'EmployeeForm' }" />
        <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template v-slot:body-cell-first_name="props">
          <q-td :props="props" class="q-gutter-sm">
            <router-link
            class="text-primary text-weight-bold"
            :to="{ name: 'ShowEmployee', params: { id: props.row.id } }" >
              {{ props.row.first_name }}
            </router-link>
          </q-td>
        </template>
        <template v-slot:body-cell-is_active="props">
          <q-td :props="props" class="q-gutter-sm">
            <q-badge :color="props.row.is_active ? 'green' : 'red'">
              {{ props.row.is_active ? 'Active' : 'Inactive' }}
            </q-badge>
          </q-td>
        </template>
      <template v-slot:body-cell-actions="props">
          <q-td :props="props">
            <q-btn flat round color="primary" icon="edit" dense @click='editEmployee(props.row.id)' />
            <q-btn flat round color="negative" icon="remove_circle" size="sm" dense @click='deleteEmployee(props.row.id)' />
          </q-td>
        </template>
      </q-table>
    </div>
  </q-page>
</template>

<script>
import { onMounted, ref, computed } from 'vue'
import EmployeesService from 'src/services/employees'
import { useQuasar } from 'quasar'
import LatestEmployee from 'src/components/LatestEmployee.vue'
import { useRouter } from 'vue-router'

export default {
  name: 'IndexPage',
  components: {
    LatestEmployee
  },
  setup () {
    const employees = ref([])
    const { list, destroy } = EmployeesService()
    const router = useRouter()
    const columns = [
      { name: 'first_name', align: 'left', label: 'First Name', field: 'first_name', sortable: true },
      { name: 'last_name', align: 'left', label: 'Last Name', field: 'last_name', sortable: true },
      { name: 'identification_number', align: 'left', label: 'ID', field: 'identification_number', sortable: true },
      { name: 'is_active', align: 'left', label: 'Status', field: 'is_active', sortable: true },
      { name: 'actions', align: 'left', label: '', field: 'actions', sortable: false }
    ]
    const pagination = ref({
      sortBy: 'desc',
      descending: false,
      page: 2,
      rowsPerPage: 9
    })
    const $q = useQuasar()
    onMounted(() => {
      getEmployees()
    })

    const getEmployees = async () => {
      try {
        const data = await list()
        employees.value = data
      } catch (error) {
        console.log(error)
      }
    }

    const deleteEmployee = async (id) => {
      try {
        $q.dialog({
          title: '<p class="text-primary">Confirmation Required</p>',
          message: '<p class="text-primary">Are you sure you want to delete this record?</p>',
          cancel: true,
          persistent: true,
          html: true,
          ok: {
            color: 'primary'
          }
        }).onOk(async () => {
          $q.loading.show({
            delay: 400
          })
          await destroy(id)
          $q.loading.hide()
          $q.notify({ color: 'positive', message: 'Record deleted successfully', icon: 'done', position: 'top' })
          window.location.reload()
        })
      } catch (error) {
        $q.notify({ color: 'warning', message: 'Error deleting record', icon: 'warning', position: 'top' })
      }
    }

    const editEmployee = async (id) => {
      router.push({ name: 'EmployeeForm', params: { id } })
    }

    const pagesNumber = computed(() => employees.value.length / pagination.value.rowsPerPage)

    return {
      employees,
      columns,
      pagination,
      pagesNumber,
      filter: ref(''),
      deleteEmployee,
      editEmployee
    }
  }
}
</script>
