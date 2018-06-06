export class Tour {
    category_name    : string;
    categry_image    : string;
    id               : number;
    name             : string;
    duration         : number;
    cities           : number;
    distance         : number;
    price_normal     : number;
    price_sale       : number;
    price_driver     : number;
    price_nondriver  : number;
    itinerary        : number;
    dates            : object[];
    min_rider        : number;
    max_rider        : number;
    image            : string;
    image_detail     : string;

    constructor(
        category_name     : string,
        category_image    : string,
        name              : string,
        duration          : number, 
        cities            : number, 
        distance          : number, 
        price_normal      : number, 
        price_sale        : number,
        price_driver      : number,
        price_nondriver   : number,
        itinerary         : number,
        dates             : object[],
        min_rider         : number,
        max_rider         : number,
        image             : string ,
        image_detail      : string
    )
    {
        this.category_name   = category_name;
        this.categry_image   = category_image;
        this.name            = name;
        this.duration        = duration;
        this.cities          = cities;
        this.distance        = distance;
        this.price_normal    = price_normal;
        this.price_sale      = price_sale;
        this.price_driver    = price_driver;
        this.price_nondriver = price_nondriver;
        this.itinerary       = itinerary;
        this.dates           = dates;
        this.min_rider       = min_rider;
        this.max_rider       = max_rider;
        this.image           = image;
        this.image_detail    = image_detail;
    }

}