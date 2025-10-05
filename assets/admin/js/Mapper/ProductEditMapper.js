
class ProductEditMapper {
    constructor() {
        if (!ProductEditMapper.instance) {
            this.form = '#edit_form';
            this.titleRs = '#title_rs';
            this.shortDescRs = '#short_description_rs';
            this.descRs = '#description_rs';
            this.titleEn = '#title_en';
            this.shortDescEn = '#short_description_en';
            this.descEn = '#description_en';
            this.code = '#code';
            this.badge = '#badge';
            this.category = '#categories';
            this.tags = '#tags';
            this.sizes = '#sizes';
            this.redeemedSizes = '#redeemed_sizes';
            this.colors = '#colors';
            this.price = '#price';
            this.discount = '#discount';
            this.discountPercentage = '#discount_percentage';
            this.submitBtn = '#product_submit';
            this.materialClothes = '#material_clothes';
            this.materialShoes = '#material_shoes';

            ProductEditMapper.instance = this;
        }

        return ProductEditMapper.instance;
    }
}

const productEditMapper = new ProductEditMapper();

Object.freeze(productEditMapper);

export default productEditMapper;
