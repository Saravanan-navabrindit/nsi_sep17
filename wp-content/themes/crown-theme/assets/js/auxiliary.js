export const activateSpinner = (e) => {
    const selector = e?.data?.selector ?? '';
    const classes = e?.data?.classes ?? [''];
    if(selector && jQuery(selector)) {
        classes.forEach( clas => jQuery(e.data.selector).addClass(clas) );
    }
}