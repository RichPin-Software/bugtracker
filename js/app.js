/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      - Cancel button functionality
 *      - Create New User Group display
 * 
 */

let Ui = new UI();

if(cancelButtonExists = document.querySelector('.cancel-newuser'))
{
    Ui.cancelForm('.cancel-newuser', 'login.php');
}
if(cancelButtonExists = document.querySelector('.cancel-form'))
{
    Ui.cancelForm('.cancel-form','all_tasks.php?back=1');
}