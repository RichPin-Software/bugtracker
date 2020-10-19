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

    cancelForm(buttonId, event, url)
    {
        let button = document.getElementById(buttonId);

        button.addEventListener(event, ()=>{
            this.redirect(url);
        });
    }
} 