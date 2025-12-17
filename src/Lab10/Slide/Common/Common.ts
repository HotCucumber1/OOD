type Point = {
    x: number;
    y: number;
}

type Color = {
    hex: string;
}

class Frame {
    private topLeft: Point;
    private bottomRight: Point;

    public constructor(
        x1: number,
        y1: number,
        x2: number,
        y2: number,
    ) {
        this.topLeft = {x: x1, y: y1};
        this.bottomRight = {x: x2, y: y2};
    }

    public getTopLeft(): Point {
        return this.topLeft;
    }

    public setTopLeft(point: Point): void {
        this.topLeft = point;
    }

    public getBottomRight(): Point {
        return this.bottomRight;
    }

    public setBottomRight(point: Point): void {
        this.bottomRight = point;
    }

    public getWidth(): number {
        return Math.abs(this.bottomRight.x - this.topLeft.x);
    }

    public getHeight(): number {
        return Math.abs(this.bottomRight.y - this.topLeft.y);
    }
}

export {
    type Point,
    type Color,
    Frame,
}
