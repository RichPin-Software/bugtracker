/*
    Create instance of UI class
*/ 
let Ui = new UI();
/*
    Cancel form
*/
if(cancelButtonExists = document.querySelector('.cancel')) {
    Ui.cancelForm('.cancel','users.php?back=1');
}