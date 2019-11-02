<template>
    <div class="myclass">
        <i v-if="loadSpinner" class="flex-center fa fa-spin fa-spinner"></i>
            <div class="row "  v-if="departments.length">
                <div class="col py-2 px-lg-2 border">  </div>
                <div class="col py-2 px-lg-2 border text-center" v-for="department in departments" :key="department.id"> {{department.name}} </div>
            </div>
            <div class="row " v-for="employee in employees.data" :key="employee.id">
            <div class = "col py-2 px-lg-2 border"> {{employee.name}} {{employee.surname}}</div>
            <div class="col py-2 px-lg-2 border" v-for="department in departments" :key="department.id" >
                <div v-for="dep in employee.department_id" v-if="dep===department.id" class="text-center">
                    <i class="fas fa-check"></i>1
                </div>
            </div>

            </div>
            <div class = 'mt-3 flex-center'>
                <pagination :data="employees" @pagination-change-page="nextPageEmployees" ></pagination>
            </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                employees:{},
                departments:{},
                loadSpinner: false,
            }
        },
        mounted() {
            this.fetch();
        },
        methods: {
            fetch() {
                this.loadSpinner = true;
                Axios.get('../department')
                    .then((response) => {
                        if (response.data.doesNotExist===true){
                            Swal.fire({
                                text: 'Не удалось найти отдел.',
                                type: 'error',
                                toast: true,
                                position: 'top-end',
                                background: '#f2c7c7',
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                        else {
                            this.departments = response.data;
                        }
                    })
                    .catch(error => console.log(error));
                Axios.get('../employee')
                    .then(response => {
                        if (response.data.doesNotExist===true){
                            Swal.fire({
                                text: 'Не удалось найти сотрудников.',
                                type: 'error',
                                toast: true,
                                position: 'top-end',
                                background: '#f2c7c7',
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                        else {
                            this.employees = response.data
                        }
                        this.loadSpinner=false;
                    })
                    .catch(error => console.log(error));
            },
            nextPageEmployees(page = 1) {
                Axios.get('../employee?page=' + page)
                    .then(response => {
                        if (response.data.doesNotExist===true){
                            Swal.fire({
                                text: 'Не удалось найти сотрудников.',
                                type: 'error',
                                toast: true,
                                position: 'top-end',
                                background: '#f2c7c7',
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                        else {
                            this.employees = response.data
                        }
                    });
            },
        },
    }
</script>

<style scoped>
    .myclass{
        padding: 2%;
    }
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
</style>
