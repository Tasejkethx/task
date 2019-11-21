<template>
    <div class="myclass">
        <i v-if="loadSpinner" class="flex-center fa fa-spin fa-spinner"></i>
        <div class="row " v-if="departments.length">
            <div class="col py-2 px-lg-2 border"></div>
            <div class="col py-2 px-lg-2 border text-center" v-for="department in departments" :key="department.id">
                {{department.name}}
            </div>
        </div>
        <div class="row " v-for="employee in employees.data" :key="employee.id">
            <div class="col py-2 px-lg-2 border"> {{employee.name}} {{employee.surname}}</div>
            <div class="col py-2 px-lg-2 border" v-for="department in departments" :key="department.id">
                <div v-for="dep in employee.departments" v-if="dep.id==department.id" class="text-center">
                    <i class="fas fa-check"></i>
                </div>
            </div>

        </div>
        <div class='mt-3 flex-center'>
            <pagination :data="employees" @pagination-change-page="nextPageEmployees"></pagination>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        employees: {},
        departments: {},
        loadSpinner: false,
      };
    },
    mounted() {
      this.fetch();
    },
    methods: {
      fetch() {
        this.loadSpinner = true;
        Promise.all([Axios.get('../department'), Axios.get('../employee')]).
            then(([departmentResponse, employeeResponse]) => {
              this.departments = departmentResponse.data;
              this.employees = employeeResponse.data;
              this.loadSpinner = false;
            }).
            catch(error => {
              console.log(error);
            });

      },
      nextPageEmployees(page = 1) {
        Axios.get('../employee?page=' + page).then(response => {
          this.employees = response.data;
        });
      },
    },
  };
</script>

<style scoped>
    .myclass {
        padding: 2%;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
</style>
