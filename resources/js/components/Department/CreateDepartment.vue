<template>
    <div class="container">
        <div class="flex-center">
            <form v-on:submit.prevent="create" id="newForm">
                <div class="text-center py-3 mb-2">
                    <h4> Добавление нового отдела</h4>
                </div>
                <div class="mb-3">
                    <label for="name" class="font-weight-bold"> Название отдела </label>
                    <input class="form-control" type="text" id="name" name='name' @input="delete_error_message('name')" v-model="department.name">
                    <button type='submit' class="btn btn-primary mt-3"> Создать </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                department:{
                    name:null,
                },
            }
        },
        mounted() {

        },
        methods:{
            delete_error_message(className){
                const formControls= document.getElementById(className);
                if(formControls.classList.length > 1){
                    formControls.classList.forEach((element)=>{
                        if (element === 'border-danger'){
                            formControls.classList.remove('border','border-danger');
                        }
                    });
                }
                const errorMessages = document.getElementById(className+'-error');
                if (errorMessages){
                    errorMessages.textContent = '';
                }
            },
            create(){
                axios.post('../department' ,this.department)
                    .then((response) => {
                })
                    .catch(error=>{
                        // clear error messages
                        const errorMessages = document.querySelectorAll('.text-danger');
                        errorMessages.forEach((el) => el.textContent = '');

                        const formControls= document.querySelectorAll('.form-control');
                        formControls.forEach((elem)=>elem.classList.remove('border','border-danger'));

                        // show error messages
                        const errors = error.response.data.errors;
                        Object.keys(errors).forEach((element)=>{
                            const firstItemDOM =document.getElementById(element);
                            const firstErrorMessage = errors[element][0];

                            const div = document.createElement('div');
                            div.className = "text-danger";
                            div.id= firstItemDOM.id+'-error';
                            div.innerHTML = ""+firstErrorMessage;

                            firstItemDOM.insertAdjacentElement("afterend", div);
                            firstItemDOM.classList.add('border','border-danger');
                        });
                    });

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
