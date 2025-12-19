import {AbstractSlideObject} from "./AbstractSlideObject";
import {type Color, Frame} from "../../../Common/Common";

abstract class AbstractShape extends AbstractSlideObject {
    public constructor(
        protected color: Color,
        frame: Frame,
    ) {
        super(frame);
    }

    public getColor(): Color {
        return this.color;
    }

    public setColor(color: Color): void {
        this.color = color;
    }
}

export {
    AbstractShape,
}
