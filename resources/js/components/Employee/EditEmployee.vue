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
        <div class="button-wrapper-send-form">
            <button type='submit' class="btn btn-primary mt-3 mr-2 form-width-button" :disabled="loadSpinner"
                    @click="editEmployee"><i
                v-if="loadSpinner" class="fa fa-spin fa-spinner"></i> Редактировать
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
      editEmployee() {
        Axios.put('../../employee/' + this.employee.id, this.employee).then((response) => {
          console.log(response.data);
          if (response.data.id > 0) {
            SwalAlerts.employeeSuccessUpdated();
            this.$router.push({path: '/employees'});
          } else {
            SwalAlerts.employeeNotFound();
            this.$router.push({path: '/employees'});
          }
        }).catch(error => {
          validationErrors.showErrors(error);
        });
      },
      fetch() {
        this.loadSpinner = true;
        Axios.get('../../employee/' + this.$route.params.id + '/edit').then(response => {
          console.log(response.data);
          if (response.data == 0) {
            SwalAlerts.employeeNotFound();
            this.$router.push({path: '/employees'});
          } else {
            this.employee = response.data;
            let mass = [];
            this.employee.departments.forEach((element) => {
              mass.push(element.id);
            });
            this.employee.department_id = mass;
            this.loadSpinner = false;
          }
        }).catch(error => {
          SwalAlerts.errorMessage(error);
          this.$router.push({path: '/employees'});
        });
        Axios.get('../../department').then(response => this.departments = response.data).catch(error => {
              SwalAlerts.errorMessage(error);
              this.$router.push({path: '/employees'});
            },
        );
      },
    },
  };
</script>

<style scoped>
    .form-width-button {
        width: calc(25% - 80px);
    }

    .button-wrapper-send-form {
        display: flex;
        justify-content: center;
    }
</style>
