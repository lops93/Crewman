const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', name: 'home', component: () => import('pages/IndexPage.vue') },
      { path: 'employee/:id', name: 'ShowEmployee', component: () => import('pages/employees/ShowEmployee.vue') },
      { path: 'formemployee/:id?', name: 'EmployeeForm', component: () => import('pages/employees/EmployeeForm.vue') }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
