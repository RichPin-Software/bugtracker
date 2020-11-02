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