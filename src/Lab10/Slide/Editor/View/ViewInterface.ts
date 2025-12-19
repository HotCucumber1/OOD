import {Frame} from "../../Common/Common";
import type {SlideComponentInterface} from "../Model/Interface/SlideComponentInterface";


type PresenterAction = (objectId: string) => void;

interface ViewInterface {
    renderObjects(objects: SlideComponentInterface[]): void;

    onObjectClick(callback: PresenterAction): void;

    onMouseMove(callback: PresenterAction): void;

    getDefaultFrame(): Frame;
}

export {
    type ViewInterface,
};
