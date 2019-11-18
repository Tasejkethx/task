<template>
    <div class="container">
        <div class="flex-center">
            <form v-on:submit.prevent="editEmployee" id="newForm">
                <div class="text-center py-3 mb-2">
                    <h4> Редактировние сотрудника</h4>
                </div>
                <div class="mb-3">
                    <label for="name" class="font-weight-bold"> Имя </label>
                    <input type="text" class="form-control" @input="delete_error_message('name')" id="name" name='name'
                           v-model="employee.name">
                </div>
                <div class="mb-3">
                    <label for="surname" class="font-weight-bold"> Фамилия </label>
                    <input type="text" class="form-control" id="surname" @input="delete_error_message('surname')"
                           name="surname" v-model="employee.surname">
                </div>
                <div class="mb-3">
                    <label for="patronymic" class="font-weight-bold"> Отчество </label>
                    <input type="text" class="form-control" id="patronymic" @input="delete_error_message('patronymic')"
                           name="patronymic" v-model="employee.patronymic">
                </div>
                <div class="mb-3 mt-3 font-weight-bold"> Пол</div>
                <div class="d-block my-2 mb-2">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="male" name="sex" value="male"
                               @click="delete_error_message('sex')" v-model="employee.sex"/>
                        <label class="custom-control-label" for="male"> Мужчина </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="female" name="sex" value="female"
                               @click="delete_error_message('sex')" v-model="employee.sex">
                        <label class="custom-control-label" for="female"> Женщина </label>
                    </div>
                    <span class="mb-2 mt-2" id="sex"></span>
                </div>
                <div class="mb-3">
                    <label for="salary" class="font-weight-bold"> Заработная плата </label>
                    <input type="text" class="form-control" id="salary" @input="delete_error_message('salary')"
                           name="salary" v-model="employee.salary">
                </div>
                <div v-if="departments.length">
                    <div class="mb-3 mt-3 font-weight-bold"> Отделения</div>
                    <div class="custom-control custom-checkbox mb-1" v-for="department in departments"
                         :key="department.id">
                        <input type="checkbox" class="custom-control-input" :id="department.id" :value="department.id"
                               @click="delete_error_message('department_id')" v-model="employee.department_id"/>
                        <label class="custom-control-label" :for="department.id"> {{department.name}}</label>
                    </div>
                    <span class="mb-2 mt-2" id="department_id"></span>
                </div>
                <div class="button-wrapper-send-form mt-2">
                    <button type='submit' class="btn btn-primary mt-3 mr-2 form-width-button" :disabled="loadSpinner"><i
                        v-if="loadSpinner" class="fa fa-spin fa-spinner"></i> Редактировать
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  import SwalAlerts from '../../Swal'

  export default {
    data () {
      return {
        employee: {
          id: null,
          name: '',
          surname: '',
          patronymic: '',
          sex: 'male',
          salary: null,
          department_id: [],
        },
        departments: {},
        loadSpinner: false,
      }
    },
    mounted () {
      this.fetch()
    },
    methods: {
      delete_error_message (className) {
        const formControls = document.getElementById(className)
        if (formControls.classList.length > 1) {
          formControls.classList.forEach((element) => {
            if (element === 'border-danger') {
              formControls.classList.remove('border', 'border-danger')
            }
          })
        }
        const errorMessages = document.getElementById(className + '-error')
        if (errorMessages) {
          errorMessages.textContent = ''
        }
      },
      editEmployee () {
        Axios.put('../../employee/' + this.employee.id, this.employee).then((response) => {
          console.log(response.data)
          if (response.data.id > 0) {
            SwalAlerts.employeeSuccessUpdated()
            this.$router.push({ path: '/employees' })
          } else {
            SwalAlerts.employeeNotFound()
            this.$router.push({ path: '/employees' })
          }
        }).catch(error => {
          // clear error messages
          const errorMessages = document.querySelectorAll('.text-danger')
          errorMessages.forEach((el) => el.textContent = '')

          const formControls = document.querySelectorAll('.form-control')
          formControls.forEach((elem) => elem.classList.remove('border', 'border-danger'))

          // show error messages
          const errors = error.response.data.errors
          Object.keys(errors).forEach((element) => {
            const firstItemDOM = document.getElementById(element)
            const firstErrorMessage = errors[element][0]

            const div = document.createElement('div')
            div.className = 'text-danger'
            div.id = firstItemDOM.id + '-error'
            div.innerHTML = '' + firstErrorMessage

            firstItemDOM.insertAdjacentElement('afterend', div)
            firstItemDOM.classList.add('border', 'border-danger')
          })
        })
      },
      fetch () {
        this.loadSpinner = true
        Axios.get('../../employee/' + this.$route.params.id + '/edit').then(response => {
          console.log(response.data)
          if (response.data == 0) {
            SwalAlerts.employeeNotFound()
            this.$router.push({ path: '/employees' })
          } else {
            this.employee = response.data
            let mass = []
            this.employee.departments.forEach((element) => {
              mass.push(element.id)
            })
            this.employee.department_id = mass
            this.loadSpinner = false
          }
        }).catch(error => {
          SwalAlerts.errorMessage(error)
          this.$router.push({ path: '/employees' })
        })
        Axios.get('../../department').then(response => this.departments = response.data).catch(error => {
            SwalAlerts.errorMessage(error)
            this.$router.push({ path: '/employees' })
          },
        )
      },

    },
  }
</script>

<style scoped>
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .form-width-button {
        width: calc(100% - 80px);
    }

    .button-wrapper-send-form {
        display: flex;
        justify-content: center;
    }
</style>
