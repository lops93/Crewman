import useEmployeesApi from 'src/composables/useEmployeesApi'

export default function EmployeesService () {
  const { list, post, update, destroy } = useEmployeesApi('employees')

  return {
    list,
    post,
    update,
    destroy
  }
}
