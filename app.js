/*
    Create instance of UI class
*/ 
let Ui = new UI();
/*
    Cancel form
*/
if(cancelButtonExists = document.querySelector('.cancel'))
{
    Ui.cancelForm('.cancel-newuser', 'login.php');
    Ui.cancelForm('.cancel-form','users.php?back=1');
}