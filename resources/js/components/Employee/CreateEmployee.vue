<template>
    <div class="container">
        <employee-form-component
            :name.sync="employee.name"
            :surname.sync="employee.surname"
            :patronymic.sync="employee.patronymic"
            :sex.sync="employee.sex"
            :salary.sync="employee.salary"
            :department_id.sync="employee.department_id"
            :departments="departments"
        >
        </employee-form-component>
        <div class="button-wrapper-send-form mt-2">
            <button type='submit' class="btn btn-primary mt-3 mr-2 form-width-button" :disabled="loadSpinner"
                    @click="create"><i
                v-if="loadSpinner" class="fa fa-spin fa-spinner"></i> Создать
            </button>
        </div>
    </div>
</template>

<script>
  import SwalAlerts from '../../Swal';
  import validationErrors from '../../validationErrors';

  export default {
    data() {
      return {
        employee: {
          name: null,
          surname: null,
          patronymic: null,
          sex: null,
          salary: null,
          department_id: [],
        },
        departments: [],
        loadSpinner: false,
      };
    },
    mounted() {
      this.fetch();
    },
    methods: {
      create() {
        Axios.post('../employee', this.employee).then((response) => {
          if (response.data.id > 0) {
            SwalAlerts.employeeSuccessAdded();
            this.$router.push({path: '/employees'});
          } else {
            SwalAlerts.employeeFailAdded();
          }
        }).catch(error => {
          validationErrors.showErrors(error);
        });
      },
      fetch() {
        this.loadSpinner = true;
        Axios.get('../department').then(response => {
          this.departments = response.data;
          if (!this.departments.length) {
            Swal.fire({
              title: 'Предупреждение',
              text: 'Сперва добавьте отделы',
              type: 'warning',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ок',
            }).then((result) => {
              this.$router.push({path: '/employees'});
            });
          }
          this.loadSpinner = false;
        }).catch(error => {console.log(error);});
      },
    },
  };
</script>

<style scoped>
    .form-width-button {
        width: calc(35% - 60px);
    }

    .button-wrapper-send-form {
        display: flex;
        justify-content: center;
    }
</style>
