import {AbstractTask} from "../../../Common/History/AbstractTask";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import fs from "fs";
import {Image} from "../Entity/Image";

class DeleteObjectTask extends AbstractTask {
    private restoreObjects = new Map<string, SlideComponentInterface>();
    private isToDelete = true;
    private imageUrls = new Map<string, string>();

    public constructor(
        private items: Map<string, SlideComponentInterface>,
        private objectIds: string[],
    ) {
        super();
    }

    public destroy(): void {
        if (!this.isToDelete) {
            return;
        }
        Array.from(this.imageUrls.values()).forEach(url => {
            fs.unlink(url, () => {
            });
        });
    }

    protected doExecute(): void {

        this.objectIds.forEach(id => {
            if (this.items.has(id)) {
                const object = structuredClone(this.items.get(id)!);
                this.restoreObjects.set(id, object);

                if (object instanceof Image) {
                    this.imageUrls.set(id, object.getImgPath());
                }

                this.items.delete(id);
            }
        });
        this.isToDelete = true;
    }

    protected doUnexecute(): void {
        for (const [id, object] of this.restoreObjects) {
            this.items.set(id, object);
        }
        this.isToDelete = false;
    }
}

export {
    DeleteObjectTask,
}
