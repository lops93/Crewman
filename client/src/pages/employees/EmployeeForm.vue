<template>
  <q-page padding>
    <q-form
      @submit="onSubmit"
      @reset="onReset"
      class="row q-gutter-sm"
    >
      <q-input
          outlined
          v-model="form.first_name"
          label="First Name"
          lazy-rules
          class="col-lg-6 col-xs-12"
          :rules="[ val => val && val.length > 0 || 'Please type the first name']"
        />
        <q-input
        outlined
        v-model="form.last_name"
        label="Last Name"
        lazy-rules
        class="col-lg-6 col-xs-12"
        :rules="[val => val !== null && val !== '' || 'Please type the last name']"
      />
      <q-input
        outlined
        v-model="form.identification_number"
        label="ID"
        lazy-rules
        class="col-lg-6 col-xs-12"
        :maxlength="8"
        :rules="[val => val !== null && val !== '' || 'Please type the identification number']"
      /><br>
      <div class="col-12 q-gutter-sm">
        <q-btn label="save" color="primary" class="float-right" icon="save" type="submit" />
        <q-btn label="cancel" color="white" class="float-right" text-color="primary" :to="{ name: 'home' }" />
      </div>
    </q-form>
    <p class="text-subtitle2 text-red">* The status will be inactive</p>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue'
import EmployeesService from 'src/services/employees'
import { useQuasar } from 'quasar'
import { useRouter, useRoute } from 'vue-router'

export default defineComponent({
  name: 'EmployeeForm',
  setup () {
    const { post, getById, update } = EmployeesService()
    const $q = useQuasar()
    const router = useRouter()
    const route = useRoute()
    const form = ref({
      first_name: '',
      last_name: '',
      identification_number: ''
    })

    onMounted(async () => {
      if (route.params.id) {
        getEmployee(route.params.id)
      }
    })

    const getEmployee = async (id) => {
      try {
        $q.loading.show({
          delay: 400
        })
        const response = await getById(id)
        form.value = response
        $q.loading.hide()
      } catch {
        $q.loading.hide()
        $q.notify({ color: 'warning', message: 'Error retrieving data ', icon: 'warning', position: 'top' })
      }
    }

    const onSubmit = async () => {
      try {
        if (form.value.id) {
          await update(form.value)
        } else {
          console.log(form.value)
          await post(form.value)
        }
        $q.notify({ color: 'positive', message: 'Record saved successfully', icon: 'done', position: 'top' })
        router.push({ name: 'home' })
      } catch (error) {
        $q.notify({ color: 'warning', message: 'Error saving record', icon: 'warning', position: 'top' })
      }
    }

    return {
      form,
      onSubmit
    }
  }
})
</script>

<style lang="scss" scoped>

</style>
