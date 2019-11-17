<template>
    <div class="container">
        <router-link to="/employees/create" class="btn btn-dark mb-5" :disable="loadSpinner">  <i v-if="loadSpinner" class="fa fa-spin fa-spinner"></i> <i v-else class="fas fa-plus"></i> Добавить сотрудника</router-link>
        <div class="table-responsive" id="success_message">
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
                    <tr v-for="employee in employees.data" :key="employee.id">
                        <td>{{employee.id}} </td>
                        <td>{{employee.name}} </td>
                        <td>{{employee.surname}} </td>
                        <td>{{employee.patronymic}} </td>
                        <td v-if="employee.sex=='male'">мужчина </td>
                        <td v-else> женщина </td>
                        <td>{{employee.salary}}$ </td>
                       <td> {{getDepartmentNames(employee.departments)}}</td>

                        <td> <router-link :to="'/employees/edit/' + employee.id" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i> Редактировать</router-link>
                            <a  href="#" @click.prevent="confirmDelete(employee.id)" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i> Удалить
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class = 'mt-3 flex-center'>
                <pagination :data="employees" @pagination-change-page="nextPageEmployees" ></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import SwalAlerts from "../../Swal";
    export default {
        data(){
            return {
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
                Axios.get('../employee')
                    .then(response => {
                        this.employees = response.data;
                        this.loadSpinner = false;
                    })
                    .catch(error => console.log(error));
                Axios.get('../department')
                    .then(response => {
                            this.departments = response.data
                    })
                    .catch(error => console.log(error));

            },
            nextPageEmployees(page = 1) {
                this.loadSpinner = true;
                Axios.get('../employee?page=' + page)
                    .then(response => {
                            this.employees = response.data
                    });
                this.loadSpinner = false;
            },
            getDepartmentNames(employee){
                let mass=[];
                employee.forEach(function(element){
                    mass.push(element.name);
                });
                return mass.join(', ');
            },
            confirmDelete(id) {
                Swal.fire({
                    title: 'Вы уверены?',
                    text: "Подтвердите удаление сотрудника ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Отмена',
                    confirmButtonText: 'Удалить'
                }).then((result) => {
                    if (result.value) {
                        Axios.delete('../employee/' + id)
                            .then((response) => {
                                console.log(response.data);
                                if (response.data == 1) {
                                    Swal.fire(
                                        'Удалено!',
                                        "Сотрудник был удален",
                                        'success');
                                    this.fetch();
                                }
                                else if (response.data == 0) {
                                    Swal.fire(
                                        'Ошибка!',
                                        'Не удалось удалить. Возможно он уже был удален',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Ошибка!',
                                    '' + error,
                                    'error'
                                );
                            });
                    }
                })
            },
        }
    }
</script>

<style scoped>
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
</style>
