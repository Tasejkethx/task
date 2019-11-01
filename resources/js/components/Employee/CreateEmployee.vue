<template>
    <div class="container">
        <div class = "flex-center">
            <form  v-on:submit.prevent="create" id="newForm" >
                <div class="text-center py-3 mb-2">
                    <h4 id="new_employee"> Добавление нового сотрудника</h4>
                </div>
                <div class="mb-3">
                    <label class="font-weight-bold" for="name"> Имя </label>
                    <input type="text" class="form-control" @input="delete_error_message('name')" id="name" name='name' v-model="employee.name" >
                </div>
                <div class="mb-3">
                    <label class="font-weight-bold" for="surname"> Фамилия </label>
                    <input type="text"  class="form-control" id="surname" @input="delete_error_message('surname')" name="surname" v-model="employee.surname" >
                </div>
                <div class="mb-3">
                    <label class="font-weight-bold" for="patronymic"> Отчество </label>
                    <input type="text"  class="form-control" id="patronymic" @input="delete_error_message('patronymic')" name="patronymic" v-model="employee.patronymic" >
                </div>
                <div class="mb-3 mt-3 font-weight-bold"> Пол</div>
                <div class="d-block my-2 mb-2">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="male" name="sex" value="male" @click="delete_error_message('sex')" v-model="employee.sex" >
                        <label  class="custom-control-label" for="male"> Мужчина </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="female" name="sex" value="female" @click="delete_error_message('sex')" v-model="employee.sex">
                        <label class="custom-control-label" for="female"> Женщина </label>
                    </div>
                    <span class="mb-2 mt-2" id="sex"></span>
                </div>
                <div class="mb-3 mt-3">
                    <label class="font-weight-bold" for="salary"> Заработная плата </label>
                    <input type="text"  class="form-control" id="salary" @input="delete_error_message('salary')" name="salary" v-model="employee.salary" >
                </div>
                <div>
                    <div v-if="departments.length">
                        <div class="mb-3 mt-3 font-weight-bold"> Отделения</div>
                        <div class="custom-control custom-checkbox mb-1" v-for="department in departments" :key="department.id">
                            <input type = "checkbox" name="department_id"  @click="delete_error_message('department_id')" class="custom-control-input"  :id="department.id" :value="department.id"  v-model="employee.department_id" />
                            <label class="custom-control-label" :for="department.id"> {{department.name}}</label>
                        </div>
                    </div>
                    <span class="mb-2 mt-2" id="department_id" ></span>
                </div>
                <button type='submit' class="btn btn-primary mt-3 mr-2"> Создать </button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                employee:{
                    name:null,
                    surname:null,
                    patronymic:null,
                    sex:null,
                    salary:null,
                    department_id:[],
                },
                departments:{},
            }
        },
        mounted() {
            this.fetch();
        },
        methods:{
            delete_error_message(className){
                const formControls= document.getElementById(className);
                if(formControls.classList.length > 1) {
                    formControls.classList.forEach((element) => {
                        if (element === 'border-danger') {
                            formControls.classList.remove('border', 'border-danger');
                        }
                    });
                }
                const errorMessages = document.getElementById(className+'-error');
                if (errorMessages) {
                    errorMessages.textContent = '';
                }
            },
            create(){
                Axios.post('../employee' , this.employee)
                    .then((response) => {
                        if (response.data.success === true) {
                            Swal.fire({
                                text: 'Сотрудник успешно добавлен',
                                type: 'success',
                                toast: true,
                                position: 'top-end',
                                background: '#e4ede6',
                                showConfirmButton: false,
                                timer: 3000,
                            });
                            this.$router.push({path: '/employees'});
                        }
                        else if (response.data.doesNotExist === true) {
                            Swal.fire({
                                text: 'Не удалось создать сорудника. Возможно был удален отдел',
                                type: 'error',
                                toast: true,
                                position: 'top-end',
                                background: '#e4ede6',
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        }
                    })
                    .catch(error=> {
                        // clear error messages
                        const errorMessages = document.querySelectorAll('.text-danger');
                        errorMessages.forEach((el) => el.textContent = '');

                        const formControls = document.querySelectorAll('.form-control');
                        formControls.forEach((elem) => elem.classList.remove('border', 'border-danger'));

                        // show error messages
                        const errors = error.response.data.errors;
                        Object.keys(errors).forEach((element) => {
                            const firstItemDOM = document.getElementById(element);
                            const firstErrorMessage = errors[element][0];

                            const div = document.createElement('div');
                            div.className = "text-danger";
                            div.id = firstItemDOM.id + '-error';
                            div.innerHTML = "" + firstErrorMessage;

                            firstItemDOM.insertAdjacentElement("afterend", div);
                            firstItemDOM.classList.add('border', 'border-danger');
                        });
                    });
            },
            fetch(){
                Axios.get('../department')
                    .then(response=>{
                        this.departments=response.data;
                        if (!this.departments.length) {
                            Swal.fire({
                                title: 'Предупреждение',
                                text: "Сперва добавьте отделы",
                                type: 'warning',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ок'
                            }).then((result) => {
                                this.$router.push({path: '/employees'});
                            })
                        }
                    })
                    .catch(error=>{console.log(error)});
            },
        },
    }
</script>

<style scoped>
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
</style>
