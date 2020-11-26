/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      - Cancel button functionality
 * 
 */

/*
    create instance of UI class
*/ 
let Ui = new UI();
/*
    cancel form
*/
if(cancelButtonExists = document.querySelector('.cancel-newuser'))
{
    Ui.cancelForm('.cancel-newuser', 'login.php');
}
if(cancelButtonExists = document.querySelector('.cancel-form'))
{
    Ui.cancelForm('.cancel-form','group_users.php?back=1');
}