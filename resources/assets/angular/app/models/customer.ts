export class Customer {
    id                    : number;
    firstname             : string;
    lastname              : string;
    title_id              : number;
    mobile                : string;
    country_id            : number;
    lbmt_tshirt_id        : number;
    code                  : string;
    price                 : string;
    date                  : string;
    rider                 : string;
    item_id               : number;
    card_id               : string;
    constructor(
        id                    : number,
        firstname             : string,
        lastname              : string,
        title_id              : number,
        mobile                : string,
        country_id            : number,
        lbmt_tshirt_id        : number,
        code                  : string,
        price                 : string,
        date                  : string,
        rider                 : string,
        item_id               : number,
        card_id               : string
    )
    {
        this.id                       = id;
        this.firstname                = firstname;
        this.lastname                 = lastname;
        this.title_id                 = title_id;
        this.mobile                   = mobile;
        this.country_id               = country_id;
        this.lbmt_tshirt_id           = lbmt_tshirt_id;
        this.card_id                  = card_id;
        this.code                     = code;
        this.date                     = date;
        this.price                    = price;
        this.rider                    = rider;
        this.item_id                  = item_id;
    }

}
