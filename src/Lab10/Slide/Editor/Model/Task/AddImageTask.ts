import {AbstractAddObjectTask} from "./AbstractAddObjectTask";
import type {Point} from "../../../Common/Common";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import {Image} from "../Entity/Image";
import type {ImageSaveStrategyInterface} from "../Service/ImageSave";
import fs from "fs";

class AddImageTask extends AbstractAddObjectTask {
    private newUrl: string = '';
    private isToDelete = true;

    public constructor(
        items: Map<string, SlideComponentInterface>,
        private pos: Point,
        private width: number,
        private height: number,
        private src: string,
        private imageService: ImageSaveStrategyInterface,
    ) {
        super(items);
    }

    protected doExecute() {

        this.newUrl = this.imageService.save(this.src);
        const img = new Image(
            this.pos.x,
            this.pos.y,
            this.width,
            this.height,
            this.newUrl,
        );
        this.storeObject(img);
        this.isToDelete = false;
    }

    public destroy() {
        if (!this.isToDelete) {
            return;
        }
        fs.unlink(this.newUrl, () => {
        });
    }

    protected doUnexecute(): void {
        this.items.delete(this.id);
        this.isToDelete = true;
    }

    protected storeObject(object: SlideComponentInterface): string {
        const uuid = crypto.randomUUID();
        this.items.set(uuid, object);

        return uuid;
    }
}

export {
    AddImageTask,
};
