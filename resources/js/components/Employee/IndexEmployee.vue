<template>
    <div class="container">
        <router-link to="/employees/create" class="btn btn-dark mb-5" ><i class="fas fa-plus"></i> Добавить сотрудника</router-link>
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
                    <tr v-for="employee in employees" :key="employee.id">
                        <td>{{employee.id}} </td>
                        <td>{{employee.name}} </td>
                        <td>{{employee.surname}} </td>
                        <td>{{employee.patronymic}} </td>
                        <td v-if="employee.sex=='male'">мужчина </td>
                        <td v-else> женщина </td>
                        <td>{{employee.salary}}$ </td>
                        <td >{{employee.department_name}} </td>
                        <td> <router-link :to="'/employees/edit/' + employee.id" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i> Редактировать</router-link>
                            <a  href="#" @click.prevent="confirmDelete(employee.id)" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i> Удалить
                            </a>
                        </td>
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
        methods: {
            fetch() {
                Axios.get('../employee')
                    .then(response => this.employees = response.data)
                    .catch(error => console.log(error));
                Axios.get('../department')
                    .then(response => this.departments = response.data)
                    .catch(error => consoloe.log(error));
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
                                if (response.data.success === true) {
                                    Swal.fire(
                                        'Удалено!',
                                        "Сотрудник был удален",
                                        'success');
                                    this.fetch();
                                } else if (response.data.doesNotExist === true) {
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

</style>
