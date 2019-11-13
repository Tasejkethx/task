export default class SwalAlerts {
/* eslint no-undef:0 */
  static employeeSuccessAdded () {
    Swal.fire({
      text: 'Сотрудник успешно добавлен',
      type: 'success',
      toast: true,
      position: 'top-end',
      background: '#e4ede6',
      showConfirmButton: false,
      timer: 3000
    })
  }

  static employeeFailAdded () {
    Swal.fire({
      text: 'Не удалось создать сотрудника. Возможно был удален отдел',
      type: 'error',
      toast: true,
      position: 'top-end',
      background: '#e4ede6',
      showConfirmButton: false,
      timer: 3000
    })
  }

  static departmentNotFound () {
    Swal.fire({
      text: 'Не удалось найти отдел.',
      type: 'error',
      toast: true,
      position: 'top-end',
      background: '#f2c7c7',
      showConfirmButton: false,
      timer: 3000
    })
  }

  static employeeNotFound () {
    Swal.fire({
      text: 'Не удалось найти сотрудника. Возможно он был удален',
      type: 'error',
      toast: true,
      position: 'top-end',
      background: '#f2c7c7',
      showConfirmButton: false,
      timer: 3000
    })
  }

  static employeeSuccessUpdated () {
    Swal.fire({
      text: 'Сотрудник успешно отредактирован',
      type: 'success',
      toast: true,
      position: 'top-end',
      background: '#e4ede6',
      showConfirmButton: false,
      timer: 3000
    })
  }

  static errorMessage () {
    Swal.fire({
      text: 'Ошибка',
      type: 'error',
      toast: true,
      position: 'top-end',
      background: '#f2c7c7',
      showConfirmButton: false,
      timer: 3000
    })
  }

  static departmentSuccessAdded () {
    Swal.fire({
      text: 'Отдел успешно добавлен',
      type: 'success',
      toast: true,
      position: 'top-end',
      background: '#e4ede6',
      showConfirmButton: false,
      timer: 3000
    })
  }

  static departmentSuccessUpdated () {
    Swal.fire({
      text: 'Отдел успешно отредактирован',
      type: 'success',
      toast: true,
      position: 'top-end',
      background: '#e4ede6',
      showConfirmButton: false,
      timer: 3000
    })
  }

  static dialogDepartmentDelete (id, name) {
    Swal.fire({
      title: 'Вы уверены?',
      text: 'Подтвердите удаление ' + "'" + name + "'",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Отмена',
      confirmButtonText: 'Удалить'
    })
  }
}
