export class Contact {
    firstname : string;
    lastname  : string;
    phone     : string;
    email     : string;
    message   : string;
    
    constructor(
        firstname : string,
        lastname  : string,
        phone     : string,
        email     : string,
        message   : string
    )
    {
        this.firstname = firstname;
        this.lastname  = lastname;
        this.phone     = phone;
        this.email     = email;
        this.message   = message;
    }
}