import baseFormMapper from "./BaseFormMapper";

class VideoMapper {
    constructor() {
        if (!VideoMapper.instance) {
            for(const [locale, data] of Object.entries(LOCALES)) {
                this[`title_${locale}`] = '#title_'+locale;
                this[`description_${locale}`] = '#description_'+locale;
            }

            VideoMapper.instance = Object.assign(this, baseFormMapper);
        }

        return VideoMapper.instance;
    }
}

const videoMapper = new VideoMapper();
Object.freeze(videoMapper);
export default videoMapper;
