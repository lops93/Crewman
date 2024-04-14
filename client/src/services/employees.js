import useEmployeesApi from 'src/composables/useEmployeesApi'

export default function EmployeesService () {
  const { list, getById, post, update, destroy } = useEmployeesApi('employees')

  return {
    list,
    getById,
    post,
    update,
    destroy
  }
}
