<template>
    <div class="container">
        <router-link to = "/departments/create" class="btn btn-dark mb-5" :disabled="loadSpinner"> <i v-if="loadSpinner" class="fa fa-spin fa-spinner"></i> <i  v-else class="fas fa-plus"></i> Добавить отдел</router-link>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th> ID</th>
                        <th> Название отдела</th>
                        <th> Количество сотрудников</th>
                        <th> Максимальная з/п</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody v-if="departments.length">
                    <tr v-for="department in departments" :key="departments.id">
                        <td> {{department.id}}</td>
                        <td> {{department.name}}</td>
                        <td> {{department.amount}}</td>
                        <td> {{department.max_salary}}$</td>
                        <td>
                            <router-link :to="'/departments/edit/' + department.id" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i> Редактировать</router-link>
                            <a  href="#" @click.prevent="confirmDelete(department.id, department.name)" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt"></i> Удалить </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import SwalAlerts from "../../Swal";
    export default {
        data() {
            return {
                departments: {},
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
                    .then(response =>  {
                        if (response.data.doesNotExist===true){
                          SwalAlerts.errorMessage();
                        }
                        else{
                            this.departments = response.data
                        }
                        this.loadSpinner = false;
                    })
                    .catch(error => console.log(error));

            },
            confirmDelete(id, name) {
                Swal.fire({
                    title: 'Вы уверены?',
                    text: "Подтвердите удаление " + "'" + name + "'",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Отмена',
                    confirmButtonText: 'Удалить'
                }).then((result) => {
                    if (result.value) {
                        Axios.delete('../department/' + id)
                            .then((response) => {
                                console.log(response.data);
                                if (response.data == 2) {
                                    Swal.fire(
                                        'Ошибка!',
                                        'Невозможно удалить отдел в котором есть сотрудники',
                                        'error');
                                    this.fetch();
                                } else if (response.data == 1) {
                                    Swal.fire(
                                        'Удалено!',
                                        'Отдел ' + "'" + name + "'" + " был успешно удален",
                                        'success');
                                    this.fetch();
                                } else if (response.data == 0) {
                                    Swal.fire(
                                        'Ошибка!',
                                        'Не удалось удалить ' + "'" + name + "'" + " возможно он уже удален",
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
                });
            },
        }
    }
</script>

<style scoped>

</style>
