import type {Frame} from "../../Common/Common";
import type {ObjectGroup} from "../Entity/ObjectGroup";
import type {CopyableInterface} from "./CopyableInterface";

interface SlideComponentInterface extends CopyableInterface {
    setPosition(newX: number, newY: number): void;

    resize(newWidth: number, newHeight: number): void;

    getFrame(): Frame;

    setFrame(frame: Frame): void;

    getGroup(): ObjectGroup | null;
}

export type {
    SlideComponentInterface,
};
