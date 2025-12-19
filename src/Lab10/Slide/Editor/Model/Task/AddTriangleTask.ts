import {AbstractAddObjectTask} from "./AbstractAddObjectTask";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import type {Color, Point} from "../../../Common/Common";
import {Triangle} from "../Entity/Triangle";

class AddTriangleTask extends AbstractAddObjectTask {
    public constructor(
        items: Map<string, SlideComponentInterface>,
        private p1: Point,
        private p2: Point,
        private p3: Point,
        private color: Color
    ) {
        super(items);
    }

    protected doExecute(): void {
        const rect = new Triangle({
            p1: this.p1,
            p2: this.p2,
            p3: this.p3,
        }, this.color);
        this.id = this.storeObject(rect);
    }
}

export {
    AddTriangleTask,
};
