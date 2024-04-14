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
          Created at: <b>{{ formatDate(field.created_at) }}</b>
        </q-item-section>
      </q-item>
      <div class="q-px-lg q-py-md">
        <q-timeline color="primary">
          <h6 class="q-mb-sm"><q-timeline-entry body="Assignments" /></h6>
          <q-timeline-entry
          title="Assignment Title"
          subtitle="Assigment date"
          icon="assignment"
          :body="body"
        />
        </q-timeline>
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
      created_at: ''
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
    const formatDate = (dateString) => new Date(dateString).toLocaleDateString('en-GB')
    return {
      field,
      formatDate
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
