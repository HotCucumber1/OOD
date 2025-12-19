import {AbstractShape} from "./AbstractShape";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import {
    Frame,
    type Color,
    type Point,
} from "../../../Common/Common";

class Ellipse extends AbstractShape {
    private center: Point;
    private rx: number;
    private ry: number;

    public constructor(
        center: Point,
        rx: number,
        ry: number,
        color: Color,
    ) {
        super(
            color,
            new Frame(
                center.x - rx,
                center.y - ry,
                center.x + rx,
                center.y + ry,
            ),
        );

        this.center = center;
        this.rx = rx;
        this.ry = ry;
    }

    public clone(): SlideComponentInterface {
        return new Ellipse(
            {
                x: this.center.x,
                y: this.center.y,
            },
            this.rx,
            this.ry,
            this.color,
        );
    }

    public setFrame(frame: Frame): void {
        const oldFrame = this.getFrame();

        if (oldFrame.getWidth() === 0 || oldFrame.getHeight() === 0) {
            throw new Error('Cannot scale from zero-sized frame');
        }

        const scaleX = frame.getWidth() / oldFrame.getWidth();
        const scaleY = frame.getHeight() / oldFrame.getHeight();

        this.rx = Math.round(this.rx * scaleX);
        this.ry = Math.round(this.ry * scaleY);

        const newCenterX = frame.getTopLeft().x + frame.getWidth() / 2;
        const newCenterY = frame.getTopLeft().y + frame.getHeight() / 2;

        this.center = {
            x: Math.round(newCenterX),
            y: Math.round(newCenterY),
        };

        this.frame = frame;
    }

    public getCenter(): Point {
        return this.center;
    }

    public getRadiusX(): number {
        return this.rx;
    }

    public getRadiusY(): number {
        return this.ry;
    }
}

export {
    Ellipse,
};
