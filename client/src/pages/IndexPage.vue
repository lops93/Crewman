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
      <template v-slot:body-cell-first_name="props">
          <q-td :props="props" class="q-gutter-sm">
            <router-link :to="{ name: 'ShowEmployee', params: { id: props.row.id } }" >
              {{ props.row.first_name }}
            </router-link>
          </q-td>
        </template>
      <template v-slot:body-cell-actions="props">
          <q-td :props="props">
            <q-btn flat round color="negative" icon="remove_circle" size="sm" dense @click='deleteEmployee(props.row.id)' />
          </q-td>
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
import EmployeesService from 'src/services/employees'
import { useQuasar } from 'quasar'

export default {
  name: 'IndexPage',
  setup () {
    const employees = ref([])
    const { list, destroy } = EmployeesService()
    const columns = [
      { name: 'first_name', align: 'left', label: 'First Name', field: 'first_name', sortable: true },
      { name: 'last_name', align: 'left', label: 'Last Name', field: 'last_name', sortable: true },
      { name: 'identification_number', align: 'left', label: 'ID', field: 'identification_number', sortable: true },
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
          await destroy(id)
          $q.notify({ color: 'positive', message: 'Record deleted successfully', icon: 'done', position: 'top' })
          await getEmployees()
        })
      } catch (error) {
        $q.notify({ color: 'warning', message: 'Error deleting record', icon: 'warning', position: 'top' })
      }
    }

    const pagesNumber = computed(() => employees.value.length / pagination.value.rowsPerPage)

    return {
      employees,
      columns,
      pagination,
      pagesNumber,
      deleteEmployee
    }
  }
}
</script>
