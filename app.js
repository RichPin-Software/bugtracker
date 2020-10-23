let Ui = new UI();

const btnAddTask = document.getElementById('add-task');
const btnCancel = document.getElementById('cancel');

btnAddTask.addEventListener('click', ()=> {
    Ui.hideElement('.display-table');
    Ui.showElement('.add-task-form');
});

btnCancel.addEventListener('click', ()=> {
    Ui.redirect('members.php');
});