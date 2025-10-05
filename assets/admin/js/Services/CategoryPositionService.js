import categoryEditMapper from "../Mapper/CategoryEditMapper";

class CategoryPositionService {
    constructor() {
        this.mapper = categoryEditMapper
        this.newCategoryTitle = 'Nova ktegorija';
    }

    setRelatedCategoriesByPosition()
    {
        const parentCategory = $(this.mapper.parentCategory).val();

        $(this.mapper.position).empty();

        let htmlArray = [];

        for (let i = 0; i < POSITION_OPTIONS.length; i++) {
            let category = POSITION_OPTIONS[i];

            if (parentCategory === category.parent_alias ||
                (parentCategory == -1 && category.parent_alias == '')
            ) {
                htmlArray.push(`<li class="list-group-item" 
                         data-slug="${category.slug}"
                     >${category.title}</li>`);
            }
        }

        if (PARENT_CATEGORY !== parentCategory && IS_EDIT) {
            htmlArray.push(`<li class="list-group-item" 
                         data-slug="${CATEGORY.slug}"
                     >${CATEGORY.title}</li>`);
        }

        if (!IS_EDIT) {
            htmlArray.push(`<li class="list-group-item" 
                         data-slug=""
                     >${this.newCategoryTitle}</li>`);
        }

        $(this.mapper.position).append(htmlArray.join(''));
    }

    /**
     *
     * @param {string} title
     */
    updateTitleOnNewCategoryPosition(title)
    {
        let elm = document.querySelector(`${this.mapper.position} li[data-slug='']`);

        if (null !== elm) {
            elm.textContent = title;
            this.newCategoryTitle = title;
        }
    }
}

export default CategoryPositionService;
