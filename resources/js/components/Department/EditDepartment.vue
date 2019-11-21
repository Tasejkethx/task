<template>
    <div class="container">
        <department-form-component
            :myName="department.name"
            v-model="department.name"
        >
        </department-form-component>
        <div class="button-wrapper-send-form">
            <button type='submit' class="btn btn-primary mt-3 form-width-button" :disabled="loadSpinner"
                    @click="editDepartment"><i
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
        department: {
          id: null,
          name: '',
        },
        loadSpinner: false,
      };
    },
    mounted() {
      this.fetch();
    },
    methods: {
      editDepartment() {
        Axios.put('../../department/' + this.department.id, this.department).then((response) => {
          if (response.data.id > 0) {
            SwalAlerts.departmentSuccessUpdated();
            this.$router.push({path: '/departments'});
          } else {
            SwalAlerts.departmentNotFound();
            this.$router.push({path: '/departments'});
          }
        }).catch(error => {
          validationErrors.showErrors(error);
        });
      },
      fetch() {
        this.loadSpinner = true;
        Axios.get('../../department/' + this.$route.params.id + '/edit').then(response => {
          this.department = response.data;
          this.loadSpinner = false;
        }).catch(error => {
          SwalAlerts.errorMessage(error);
          this.$router.push({path: '/departments'});
        });
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
