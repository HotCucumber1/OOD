import {AbstractAddObjectTask} from "./AbstractAddObjectTask";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import type {Color, Point} from "../../../Common/Common";
import {Ellipse} from "../Entity/Ellipse";

class AddEllipseTask extends AbstractAddObjectTask {
    public constructor(
        items: Map<string, SlideComponentInterface>,
        private center: Point,
        private rx: number,
        private ry: number,
        private color: Color
    ) {
        super(items);
    }

    protected doExecute(): void {
        const ellipse = new Ellipse(this.center, this.rx, this.ry, this.color);
        this.id = this.storeObject(ellipse);
    }
}

export {
    AddEllipseTask,
}
