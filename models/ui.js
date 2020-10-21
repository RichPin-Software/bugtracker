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

    showElement(elementId, display = 'block')
    {
        let element = document.getElementById(elementId);
        element.style.display = display;
    }

    hideElement(elementId)
    {
        let element = document.getElementById(elementId);
        element.style.display = 'none';
    }

    cancelForm(buttonId, event, url)
    {
        let button = document.getElementById(buttonId);

        button.addEventListener(event, ()=> {
            this.redirect(url);
        });
    }
} 