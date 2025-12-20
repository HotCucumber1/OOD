import type {Frame} from "../../../Common/Common";
import type {CopyableInterface} from "./CopyableInterface";
import type {GroupInterface} from "./GroupInterface";

interface SlideComponentInterface extends CopyableInterface {
    setPosition(newX: number, newY: number): void;

    resize(newWidth: number, newHeight: number): void;

    getFrame(): Frame;

    setFrame(frame: Frame): void;

    getGroup(): GroupInterface | null;

    // serialize(): string;
}

export type {
    SlideComponentInterface,
};
