import {Frame} from "../../../Common/Common";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import {type ObjectGroup} from "./ObjectGroup";

abstract class AbstractSlideObject implements SlideComponentInterface {
    protected constructor(
        protected frame: Frame,
    ) {
    }

    public getFrame(): Frame {
        return this.frame;
    }

    public getGroup(): ObjectGroup | null {
        return null;
    }

    public setPosition(newX: number, newY: number) {
        const deltaX = this.frame.getTopLeft().x - newX;
        const deltaY = this.frame.getTopLeft().y - newY;

        this.frame = new Frame(
            newX,
            newY,
            this.frame.getBottomRight().x - deltaX,
            this.frame.getBottomRight().y - deltaY,
        );
    }

    resize(newWidth: number, newHeight: number) {
        let newBottomRightX = this.frame.getTopLeft().x + newWidth;
        let newBottomRightY = this.frame.getTopLeft().y + newHeight;

        const position = this.frame.getTopLeft();
        if (position.x > newBottomRightX)
        {
            [position.x, newBottomRightX] = [newBottomRightX, position.x];
        }
        if (position.y > newBottomRightY)
        {
            [position.y, newBottomRightY] = [ newBottomRightY, position.y];
        }

        this.frame = new Frame(
            position.x,
            position.y,
            newBottomRightX,
            newBottomRightY,
        );
    }


    public abstract clone(): SlideComponentInterface;

    public abstract setFrame(frame: Frame): void;
}

export {
    AbstractSlideObject,
};
