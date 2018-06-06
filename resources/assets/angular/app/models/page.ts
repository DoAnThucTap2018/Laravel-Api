export class Page {
    name          : string;
    title         : string;
    slug          : string;
    content       : string;
    extras        : string;
    external_link : string;
    picture       : string;
    name_color    : string;
    title_color   : string;
    target_blank  : number;
    active        : number;
    constructor(
        name          : string,
        title         : string,
        slug          : string,
        content       : string,
        extras        : string,
        external_link : string,
        picture       : string,
        name_color    : string,
        title_color   : string,
        target_blank  : number,
        active        : number,
    )
    {
        this.name          = name;
        this.title         = title;
        this.slug          = slug;
        this.content       = content;
        this.extras        = extras;
        this.external_link = external_link;
        this.picture       = picture;
        this.name_color    = name_color;
        this.title_color   = title_color;
        this.target_blank  = target_blank;
        this.active        = active;

    }

}