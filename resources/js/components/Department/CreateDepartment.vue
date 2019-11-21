<template>
    <div class="container">
        <department-form-component
            v-model="department.name"
        >
        </department-form-component>
        <div class="button-wrapper-send-form mt-2">
            <button class="btn btn-primary mt-3 form-width-button" @click="create"> Создать</button>
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
          name: '',
        },
      };
    },
    methods: {
      getName: function(myName) {
        this.name = myName;
      },
      create() {
        Axios.post('../department', this.department).then((response) => {
          console.log(response.data);
          if (response.data.id > 0) {
            SwalAlerts.departmentSuccessAdded();
            this.$router.push({path: '/departments'});
          } else {
            SwalAlerts.errorMessage();
          }
        }).catch(error => {
          validationErrors.showErrors(error);
        });

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
