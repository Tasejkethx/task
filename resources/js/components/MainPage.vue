<template>
    <div class="myclass">
        <div v-if="employees.length">
            <div class="row " >
                <div class="col py-2 px-lg-2 border">  </div>
                <div class="col py-2 px-lg-2 border text-center" v-for="department in departments" :key="department.id"> {{department.name}} </div>
            </div>
            <div class="row " v-for="employee in employees" :key="employee.id">
            <div class = "col py-2 px-lg-2 border"> {{employee.name}} {{employee.surname}}</div>
            <div class="col py-2 px-lg-2 border" v-for="department in departments" :key="department.id" >
                <div v-for="dep in employee.department_id" v-if="dep===department.id" class="text-center">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            </div>
        </div>
        <div v-else class="font-weight-bold"> Список сотрудников пуст...</div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                employees:{},
                departments:{},
            }
        },
        mounted() {
            this.fetch();
        },
        methods:{
            fetch(){
                Axios.get('../department')
                    .then(response=>{
                        this.departments=response.data;
                    })
                    .catch(error=>console.log(error));
                Axios.get('../employee')
                    .then(response=>this.employees=response.data)
                    .catch(error=>console.log(error));
            }
        },
    }
</script>

<style scoped>
    .myclass{
        padding: 2%;
    }
</style>
