export class MetaTags {
    id: number;
    page: string;
    title: string;
    description: string;
    image: string;
    keywords: string;
    active: number;

    constructor(
        id: number,
        page: string,
        title: string,
        description: string,
        keywords: string,
        image: string,
        active: number
    )
    {
      this.id = id;
      this.title = title;
      this.page = page;
      this.description = description;
      this.image = image;
      this.keywords = keywords;
      this.active = active;
    }
}