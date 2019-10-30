<template>
    <div class="container">
        <router-link to="/employees/create" class="btn btn-dark mb-5" ><i class="fas fa-plus"></i> Добавить сотрудника</router-link>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Отчество</th>
                    <th>Пол</th>
                    <th>Заработная плата</th>
                    <th>Отделы</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="employee in employees" :key="employee.id">
                    <td>{{employee.id}} </td>
                    <td>{{employee.name}} </td>
                    <td>{{employee.surname}} </td>
                    <td>{{employee.patronymic}} </td>
                    <td v-if="employee.sex=='male'">мужчина </td>
                    <td v-else> женщина </td>
                    <td>{{employee.salary}}$ </td>
                    <td>{{employee.department_id}} </td>
                    <td> <router-link :to="'/employees/edit/' + employee.id" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Редактировать</router-link>
                        <a  href="#" @click.prevent="deleteEmployee(employee.id)" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt"></i> Удалить </a></td>
                </tr>
                </tbody>
            </table>

        </div>




    </div>
</template>

<script>
    export default {
        data(){
            return {
                employees:{},
                delstatus:{},
                departments:{},
            }
        },
        mounted() {
            this.fetch();
        },
        methods:{
            fetch(){
                Axios.get('../employee')
                    .then(response=>this.employees=response.data)
                    .catch(error => console.log(error));
                Axios.get('../department')
                    .then(response=>this.departments=response.data)
                    .catch(error=>consoloe.log(error));
            },
            deleteEmployee(id){
                Axios.delete('../employee/'+id)
                    .then(response=> this.delstatus=response.data['status'])
                    .catch(error =>console.log(error));
                console.log(this.delstatus);
                this.fetch();
            },
        }
    }
</script>

<style scoped>

</style>
