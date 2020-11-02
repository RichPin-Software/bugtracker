/*
    Create instance of UI class
*/ 
let Ui = new UI();
/*
    Cancel form
*/
if(cancelButtonExists = document.querySelector('.cancel-newuser'))
{
    Ui.cancelForm('.cancel-newuser', 'login.php');
}
if(cancelButtonExists = document.querySelector('.cancel-form'))
{
    Ui.cancelForm('.cancel-form','users.php?back=1');
}