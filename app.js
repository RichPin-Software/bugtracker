/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      - Cancel button functionality
 *      - Create New User Group display
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
    Ui.cancelForm('.cancel-form','all_tasks.php?back=1');
}
/*
    show 'Create Group' on New User signup page
*/
/*
if(onNewUserSignupPage = document.querySelector('#groupname'))
{
    const groupnameLabel = document.querySelector('#groupname-label');
    const groupnameInput = document.querySelector('#groupname');
    const groupnameError = document.querySelector('#groupname-error');
    const groupnameBr = document.querySelector('#groupname-br');
    const groupSignup = document.querySelector('#group-signup');

    groupSignup.addEventListener('click', (e)=> {
        groupnameLabel.style.display = "inline";
        groupnameInput.style.display = "block";
        groupnameError.style.display = "block";
        groupnameBr.style.display = "inline";
        groupSignup.style.display = "none";
    });
}
*/