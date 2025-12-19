import {AbstractShape} from "./AbstractShape";
import {Frame, type Color} from "../../../Common/Common";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";

class Rectangle extends AbstractShape {
    public constructor(
        x1: number,
        y1: number,
        x2: number,
        y2: number,
        color: Color,
    ) {
        super(
            color,
            new Frame(x1, y1, x2, y2),
        );
    }

    public setFrame(frame: Frame) {
        this.frame = frame;
    }

    public clone(): SlideComponentInterface {
        return new Rectangle(
            this.frame.getTopLeft().x,
            this.frame.getTopLeft().y,
            this.frame.getBottomRight().x,
            this.frame.getBottomRight().y,
            this.color,
        );
    }
}

export {
    Rectangle,
};
