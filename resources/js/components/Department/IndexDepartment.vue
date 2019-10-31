<template>
    <div class="container">
        <router-link to = "/departments/create" class="btn btn-dark mb-5" ><i class="fas fa-plus"></i> Добавить отдел</router-link>

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
                <tbody>
                <tr v-for="department in departments" :key="departments.id">
                    <td> {{department.id}}</td>
                    <td> {{department.name}}</td>
                    <td> {{department.amount}}</td>
                    <td> {{department.max_salary}}$</td>
                    <td>    <router-link :to="'/departments/edit/' + department.id" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i> Редактировать</router-link>
                        <a  href="#" @click.prevent="deleteDepartment(department.id)" class="btn btn-sm btn-danger">
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
                departments:{},
                delstatus:{},
            }
        },
        mounted() {
            this.fetch();
        },
        methods:{
            fetch(){
                Axios.get('../department')
                    .then(response=>this.departments=response.data)
                    .catch(error => console.log(error));
            },
            deleteDepartment(id){
                if(confirm("Вы действительно хотите удалить отдел?")){
                Axios.delete('../department/'+id)
                    .then((response)=> {
                        console.log(response.data);
                        if(response.data.amount ===true){
                            alert("Невозможно удалить отдел, т.к в нем есть сотрудники");
                        }
                    })
                    .catch(error =>console.log(error));
                console.log(this.delstatus);
                this.fetch();
                }
            },
        }
    }
</script>

<style scoped>

</style>
