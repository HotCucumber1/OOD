import path from 'path';
import fs from 'fs';

interface ImageSaveStrategyInterface {
    save(sourceUrl: string): string;
}


class ImageSave implements ImageSaveStrategyInterface {
    private DST_DIR = './uploads';

    public save(sourceUrl: string): string {
        const extension = this.getFileExtension(sourceUrl);
        const newName = `${crypto.randomUUID()}${extension}`;

        const targetDir = this.DST_DIR;

        if (!fs.existsSync(targetDir)) {
            fs.mkdir(targetDir, () => {
            });

            if (!fs.existsSync(targetDir)) {
                throw new Error(`Directory ${targetDir} was not created`);
            }
        }

        const fileUrl = targetDir + '/' + newName;
        fs.copyFile(sourceUrl, fileUrl, () => {
        });

        return fileUrl;
    }

    private getFileExtension(filename: string): string {
        const lastDotIndex = filename.lastIndexOf('.');
        return lastDotIndex !== -1 ? filename.slice(lastDotIndex + 1) : '';
    }
}

export {
    type ImageSaveStrategyInterface,
    ImageSave,
}
