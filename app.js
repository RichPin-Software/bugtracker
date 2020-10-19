let Ui = new UI();
//let queryString = window.location.search;

if(Ui.mQueryString.includes('addTask'))
{
    Ui.cancelForm('cancel', 'click', 'members.php');
}