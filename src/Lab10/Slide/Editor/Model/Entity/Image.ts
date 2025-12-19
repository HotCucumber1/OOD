import {AbstractSlideObject} from "./AbstractSlideObject";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import {Frame} from "../../../Common/Common";

class Image extends AbstractSlideObject {
    public constructor(
        topLeftX: number,
        topLeftY: number,
        width: number,
        height: number,
        private imgPath: string,
    ) {
        super(
            new Frame(
                topLeftX,
                topLeftY,
                topLeftX + width,
                topLeftY + height,
            ),
        );
    }

    public clone(): SlideComponentInterface {
        return new Image(
            this.frame.getTopLeft().x,
            this.frame.getTopLeft().y,
            this.frame.getWidth(),
            this.frame.getHeight(),
            this.imgPath,
        );
    }

    public setFrame(frame: Frame): void {
        this.frame = frame;
    }

    public getImgPath(): string {
        return this.imgPath;
    }
}

export {
    Image,
}
