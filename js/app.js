/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      - form cancel button
 *      - confirm delete task
 * 
 */

let Ui = new UI();

if(cancelButtonExists = document.querySelector('.cancel-newuser'))
{
    Ui.cancelForm('.cancel-newuser', 'login.php');
}

if(cancelButtonExists = document.querySelector('.cancel-newuser'))
{
    Ui.cancelForm('.cancel-newuser', 'login.php');
}
/*
    single-user
*/
if(cancelButtonExists = document.querySelector('.cancel-form'))
{
    Ui.cancelForm('.cancel-form','all_tasks.php?back=1');
}

if(deleteButtonExists = document.querySelector('#delete-task'))
{
    const deleteButton = document.querySelector('#delete-task');

    deleteButton.addEventListener('click', (e)=> {
        var deleteTask = confirm('Are you sure you want to permanently delete this task?');

        if(deleteTask)
        {
            Ui.redirect('selected_task.php?deletetask=true');
        }
    });
}
/*
    group
*/
if(cancelButtonExists = document.querySelector('.cancel-form-group'))
{
    Ui.cancelForm('.cancel-form-group','group_all_tasks.php?back=1');
}

if(deleteButtonExists = document.querySelector('#delete-task-group'))
{
    const deleteButton = document.querySelector('#delete-task-group');

    deleteButton.addEventListener('click', (e)=> {
        var deleteTask = confirm('Are you sure you want to permanently delete this task?');

        if(deleteTask)
        {
            Ui.redirect('group_selected_task.php?deletetask=true');
        }
    });
}
/*
    button sorting
*/
if(navExists = document.querySelector('.nav'))
{
    var url = window.location.href;
    var filtertask = ['onhold', 'todo', 'inprogress', 'resolved'];

    function sortButton(button)
    {
        if(url.includes(button))
        {
            document.getElementById(`li-${button}`).style.display = 'none';
        }
    }

    window.addEventListener('load', ()=> {
        filtertask.forEach(sortButton);
    });
    


    /* switch(url)
    {
        case url.includes('onhold'):
            li = 
    } */
}