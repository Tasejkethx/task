<template>
    <div class="container">
        <div class="flex-center">
            <form v-on:submit.prevent="editDepartment" id="newForm">
                <div class="text-center py-3 mb-2">
                    <h4> Редактирование отдела</h4>
                </div>
                <div class="mb-3">
                    <label for="name" class="font-weight-bold"> Название отдела </label> <br/>
                    <input type="text" class="form-control" id="name" name='name' @input="delete_error_message('name')" v-model="department.name" >
                </div>
                <button type='submit' class="btn btn-primary mt-3"> Редактировать </button> <br/>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                department:{
                    id:null,
                    name:'',
                },
            }
        },
        mounted() {
            this.fetch();
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
            editDepartment(){
                Axios.put('../../department/' + this.department.id ,this.department)
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
            fetch() {
                Axios.get('../../department/'+this.$route.params.id+'/edit')
                    .then(response=>this.department=response.data)
                    .catch(error=>console.log(error));
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
