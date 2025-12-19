import path from 'path';
import fs from 'fs';

interface ImageSaveStrategyInterface {
    save(sourceUrl: string): string;
}


class ImageSave implements ImageSaveStrategyInterface {
    private DST_DIR = './uploads';

    public save(sourceUrl: string): string {
        const extension = path.extname(sourceUrl);
        const newName = `$crypto.randomUUID()}${extension}`;

        const targetDir = this.DST_DIR;

        if (!fs.existsSync(targetDir)) {
            fs.mkdir(targetDir, () => {
            });

            if (!fs.existsSync(targetDir)) {
                throw new Error(`Directory ${targetDir} was not created`);
            }
        }

        const fileUrl = path.join(targetDir, newName);
        fs.copyFile(sourceUrl, fileUrl, () => {
        });

        return fileUrl;
    }
}

export {
    type ImageSaveStrategyInterface,
    ImageSave,
}
