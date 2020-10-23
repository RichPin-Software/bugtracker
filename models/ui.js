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

    showElement(queryselector, display = 'block')
    {
        let element = document.querySelector(queryselector);
        element.style.display = display;
    }

    hideElement(queryselector)
    {
        let element = document.querySelector(queryselector);
        element.style.display = 'none';
    }

    cancelForm(queryselector, event, url)
    {
        let button = document.querySelector(queryselector);

        button.addEventListener(event, ()=> {
            this.redirect(url);
        });
    }
} 