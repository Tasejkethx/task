<template>
    <div class="container">
        <div class="flex-center">
            <form id="newForm">
                <div class="text-center py-3 mb-2">
                    <h4 id="new_employee"> Добавление нового сотрудника</h4>
                </div>
                <div class="mb-3">
                    <label class="font-weight-bold" for="name"> Имя </label>
                    <input type="text" class="form-control" id="name" name='name'
                           v-bind:value="name"
                           v-on:input="$emit('update:name', $event.target.value)" @input="deleteErrorMessages('name')">
                </div>
                <div class="mb-3">
                    <label class="font-weight-bold" for="surname"> Фамилия </label>
                    <input type="text" class="form-control" id="surname"
                           name="surname" :value="surname"
                           v-on:input="$emit('update:surname', $event.target.value)"
                           @input="deleteErrorMessages('surname')">
                </div>
                <div class="mb-3">
                    <label class="font-weight-bold" for="patronymic"> Отчество </label>
                    <input type="text" class="form-control" id="patronymic"
                           name="patronymic" :value="patronymic"
                           v-on:input="$emit('update:patronymic', $event.target.value)"
                           @input="deleteErrorMessages('patronymic')">
                </div>
                <div class="mb-3 mt-3 font-weight-bold"> Пол</div>
                <div class="d-block my-2 mb-2">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="male" name="sex" value="male"
                               v-on:input="$emit('update:sex', $event.target.value)" @input="deleteErrorMessages('sex')"
                               v-model="sex">
                        <label class="custom-control-label" for="male"> Мужчина </label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="female" name="sex" value="female"
                               v-on:input="$emit('update:sex', $event.target.value)" @input="deleteErrorMessages('sex')"
                               v-model="sex">
                        <label class="custom-control-label" for="female"> Женщина </label>
                    </div>
                    <span class="mb-2 mt-2" id="sex"></span>
                </div>
                <div class="mb-3 mt-3">
                    <label class="font-weight-bold" for="salary"> Заработная плата </label>
                    <input type="text" class="form-control" id="salary"
                           name="salary" v-bind:value="salary"
                           v-on:input="$emit('update:salary', $event.target.value)"
                           @input="deleteErrorMessages('salary')">
                </div>
                <div>
                    <div class="mb-3 mt-3 font-weight-bold"> Отделения</div>
                    <div class="custom-control custom-checkbox mb-1" v-for="department in departments"
                         :key="department.id">
                        <input type="checkbox" name="department_id" @input="deleteErrorMessages('department_id')"
                               class="custom-control-input" :id="department.id" :value="department.id"
                               v-model="department_id"
                               v-on:change="onDepChange"/>
                        <label class="custom-control-label" :for="department.id"> {{department.name}}</label>
                    </div>
                    <span class="mb-2 mt-2" id="department_id"></span>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  import validationErrors from '../../validationErrors';

  export default {
    props: {
      name: String,
      surname: String,
      patronymic: String,
      sex: String,
      salary: '',
      departments: Array,
      department_id: null,
    },
    methods: {
      onDepChange: function() {
        this.$emit('update:department_id', this.department_id);
      },
      deleteErrorMessages(subject) {
        validationErrors.deleteErrorMessages(subject);
      },
    },
  };
</script>

<style scoped>
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
</style>
