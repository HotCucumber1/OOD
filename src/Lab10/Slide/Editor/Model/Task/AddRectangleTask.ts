import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import type {Color, Point} from "../../../Common/Common";
import {Rectangle} from "../Entity/Rectangle";
import {AbstractAddObjectTask} from "./AbstractAddObjectTask";

class AddRectangleTask extends AbstractAddObjectTask {
    public constructor(
        items: Map<string, SlideComponentInterface>,
        private topLeft: Point,
        private bottomRight: Point,
        private color: Color,
    ) {
        super(items);
    }

    protected doExecute(): void {
        const rect = new Rectangle(
            this.topLeft.x,
            this.topLeft.y,
            this.bottomRight.x,
            this.bottomRight.y,
            this.color,
        );
        this.id = this.storeObject(rect);
    }
}

export {
    AddRectangleTask,
};
