import {AbstractShape} from "./AbstractShape";
import {type Color, Frame, type Point} from "../../Common/Common";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";

interface TrianglePoints {
    readonly p1: Point;
    readonly p2: Point;
    readonly p3: Point;
}

class Triangle extends AbstractShape {
    private vertices: [Point, Point, Point];

    public constructor(
        points: TrianglePoints,
        color: Color,
    ) {
        const {p1, p2, p3} = points;
        const minX = Math.min(p1.x, p2.x, p3.x);
        const maxX = Math.max(p1.x, p2.x, p3.x);
        const minY = Math.min(p1.y, p2.y, p3.y);
        const maxY = Math.max(p1.y, p2.y, p3.y);

        super(
            color,
            new Frame(minX, minY, maxX, maxY),
        );
        this.vertices = [p1, p2, p3];
    }

    public setFrame(frame: Frame): void {
        const oldFrame = this.getFrame();
        this.vertices = this.vertices.map(point =>
            this.transformVertex(point, oldFrame, frame)
        ) as [Point, Point, Point];

        this.frame = frame;
    }

    public clone(): SlideComponentInterface {
        const [p1, p2, p3] = this.vertices;
        return new Triangle(
            {
                p1,
                p2,
                p3,
            },
            this.color,
        );
    }

    private transformVertex(
        vertex: Point,
        oldFrame: Frame,
        newFrame: Frame
    ): Point {
        const widthRatio = oldFrame.getWidth() === 0
            ? 0
            : newFrame.getWidth() / oldFrame.getWidth();
        const heightRatio = oldFrame.getHeight() === 0
            ? 0
            : newFrame.getHeight() / oldFrame.getHeight();

        const newX = newFrame.getTopLeft().x + (vertex.x - oldFrame.getTopLeft().x) * widthRatio;
        const newY = newFrame.getTopLeft().y + (vertex.y - oldFrame.getTopLeft().y) * heightRatio;

        return {
            x: Math.round(newX),
            y: Math.round(newY),
        };
    }
}

export {
    Triangle,
    type TrianglePoints,
};
