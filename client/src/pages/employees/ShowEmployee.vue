<template>
  <q-page padding>
    <q-breadcrumbs class="text-brown">
      <template v-slot:separator>
        <q-icon
          size="1.5em"
          name="chevron_right"
          color="primary"
        />
      </template>

      <q-breadcrumbs-el label="Home" icon="home" />
      <q-breadcrumbs-el label="Employee" icon="person" />
    </q-breadcrumbs>
    <div class="employee-details">
      <q-item clickable v-ripple>
        <q-item-section side>
          <q-avatar size="120px" font-size="80px" color="grey-5" text-color="white" icon="person" />
        </q-item-section>
        <q-item-section>
          <q-item-label><h3 class="q-mb-sm">{{ field.first_name }} {{ field.last_name }}</h3></q-item-label>
          <q-item-label caption>{{ field.identification_number }}</q-item-label>
        </q-item-section>
        <q-item-section side>
          Created at: <b>{{ formatTime(field.created_at) }}</b>
        </q-item-section>
      </q-item>
      <div class="q-pa-md">
        <q-table
          grid
          flat bordered
          :card-container-class="cardContainerClass"
          title="Employments"
          :rows="field.employments"
          :columns="columns"
          row-key="name"
          hide-header
          v-model:pagination="pagination"
          :rows-per-page-options="rowsPerPageOptions"
        >
          <template v-slot:top-right>
            <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </template>

          <template v-slot:item="props">
            <div class="q-pa-xs col-xs-12 col-sm-6 col-md-4">
              <q-card flat bordered>
                <q-card-section class="text-center">
                  <strong>{{ props.row.title }}</strong>
                </q-card-section>
                <q-separator />
                <q-card-section class="flex flex-center">
                  <q-list>
                    <text-caption class="text-weight-light q-pl-md">assignments: </text-caption>
                    <q-item v-for="assignment in props.row.assignments" :key="assignment.id">
                      <q-item-section>
                        <q-item-label >{{ assignment.title }}</q-item-label>
                        <q-separator class="q-mt-sm" />
                        <text-caption class="text-weight-light q-mt-sm">employer: </text-caption>
                        <q-item-label>{{ assignment.employer.name }} </q-item-label>
                        <q-item-label v-for="location in assignment.locations" :key="location.id">
                        <q-icon name="location_on" />
                        {{ location.country }}
                        </q-item-label>
                        <text-caption class="text-weight-light q-mt-sm">Roles: </text-caption>
                        <q-item-label v-for="role in assignment.assignment_roles" :key="role.id">
                            <q-icon name="task" />
                            {{ role.title }} <br>
                            <q-badge outline color="deep-orange-10" :label="role.assignment_role_type.title" />
                        </q-item-label>
                        <text-caption class="text-weight-light q-mt-sm">Leaves: </text-caption>
                        <q-item-label v-for="leave in assignment.leaves" :key="leave.id">
                          <q-icon name="calendar_month" />
                          {{ leave.type }} <br>
                        </q-item-label>
                      </q-item-section>
                    </q-item>
                  </q-list>
                </q-card-section>
              </q-card>
            </div>
          </template>
        </q-table>
      </div>
      <div class="col-12 q-gutter-sm">
        <q-btn label="Home" color="white" class="float-right" text-color="primary" :to="{ name: 'home' }" />
      </div>
    </div>
  </q-page>
</template>

<script>
import { ref, onMounted } from 'vue'
import employeesService from 'src/services/employees'
import { useRoute } from 'vue-router'
import { useQuasar } from 'quasar'
export default {
  name: 'ShowEmployee',
  setup () {
    const { getById } = employeesService()
    const $q = useQuasar()
    const route = useRoute()
    const field = ref({
      first_name: '',
      last_name: '',
      identification_number: '',
      created_at: '',
      employments: [],
      assignment: []
    })

    onMounted(async () => {
      if (route.params.id) {
        getEmployee(route.params.id)
      }
    })

    const getEmployee = async (id) => {
      try {
        const response = await getById(id)
        field.value = response
      } catch {
        $q.notify({ color: 'warning', message: 'Error retrieving data ', icon: 'warning', position: 'top' })
      }
    }

    const formatTime = (dateString) => new Date(dateString).toLocaleString('en-GB', {
      year: 'numeric',
      month: 'numeric',
      day: 'numeric',
      hour: 'numeric',
      minute: 'numeric',
      hour12: false
    })
    const formatDate = (dateString) => dateString ? new Date(dateString).toLocaleDateString('en-GB') : ''

    return {
      field,
      formatDate,
      formatTime
    }
  }
}
</script>

<style lang="scss" scoped>
  .q-card {
    height: 500px; /* Set a fixed height for the cards */
    overflow: hidden; /* Hide overflowing content */
  }
</style>
