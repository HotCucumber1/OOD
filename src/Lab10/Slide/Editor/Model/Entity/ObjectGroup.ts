import {Frame} from "../../../Common/Common";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import type {GroupInterface} from "../Interface/GroupInterface";
import {AbstractSlideObject} from "./AbstractSlideObject";

function getFrameSize(components: SlideComponentInterface[]): Frame {
    let minX = Infinity;
    let minY = Infinity;
    let maxX = -Infinity;
    let maxY = -Infinity;

    components.forEach(component => {
        const frame = component.getFrame();

        minX = Math.min(minX, frame.getTopLeft().x);
        minY = Math.min(minY, frame.getTopLeft().y);
        maxX = Math.max(maxX, frame.getBottomRight().x);
        maxY = Math.max(maxY, frame.getBottomRight().y);
    });

    return new Frame(minX, minY, maxX, maxY)
}

class ObjectGroup extends AbstractSlideObject implements GroupInterface {
    public constructor(
        private components: SlideComponentInterface[],
    ) {
        super(getFrameSize(components));
    }

    public addComponent(component: SlideComponentInterface): void {
        this.components.push(component);
    }

    public setFrame(frame: Frame): void {
        const origFrame = this.getFrame();

        const scaleX = frame.getWidth() / origFrame.getWidth();
        const scaleY = frame.getHeight() / origFrame.getHeight();

        this.components.forEach(component => {
            const shapeOrigFrame = component.getFrame();

            const relativeLeft = shapeOrigFrame.getTopLeft().x - origFrame.getTopLeft().x;
            const relativeTop = shapeOrigFrame.getTopLeft().y - origFrame.getTopLeft().y;
            const relativeRight = shapeOrigFrame.getBottomRight().x - origFrame.getTopLeft().x;
            const relativeBottom = shapeOrigFrame.getBottomRight().y - origFrame.getTopLeft().y;

            const newLeft = frame.getTopLeft().x + relativeLeft * scaleX;
            const newTop = frame.getTopLeft().y + relativeTop * scaleY;
            const newRight = frame.getTopLeft().x + relativeRight * scaleX;
            const newBottom = frame.getTopLeft().y + relativeBottom * scaleY;

            const newFrame = new Frame(
                Math.round(newLeft),
                Math.round(newTop),
                Math.round(newRight),
                Math.round(newBottom)
            );

            component.setFrame(newFrame);
        })
    }

    public getGroup(): ObjectGroup | null {
        return this;
    }

    public clone(): SlideComponentInterface {
        return this;
    }
}

export {
    ObjectGroup,
}
