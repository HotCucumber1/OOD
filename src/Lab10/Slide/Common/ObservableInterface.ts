import type {ObserverInterface} from "./ObserverInterface";

interface ObservableInterface {
    registerObserver(observer: ObserverInterface): void;

    removeObserver(observer: ObserverInterface): void;

    notifyObservers(): void;
}

export {
    type ObservableInterface,
};
