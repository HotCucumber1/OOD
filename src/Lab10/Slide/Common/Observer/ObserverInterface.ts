import type {SlideComponentInterface} from "../../Editor/Model/Interface/SlideComponentInterface";

interface ObserverInterface {
    update(objects: SlideComponentInterface[]): void;
}

export {
    type ObserverInterface,
};
