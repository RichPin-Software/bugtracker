/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      UI class for handling basic functions
 *      in the user interface. 
 * 
 */
class UI
{
    mQueryString;
    /*
        Constructor
    */
    constructor() 
    {
        this.mQueryString = window.location.search;
    }
    /*
        UI Methods
    */
    redirect(url)
    {
        return window.location.href = url;
    }

    cancelForm(queryselector, url)
    {
        let button = document.querySelector(queryselector);

        button.addEventListener('click', ()=> {
            this.redirect(url);
        });
    }
} 