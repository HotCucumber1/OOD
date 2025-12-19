import type {SaverInterface} from "./SaverInterface";

class JsonSaver implements SaverInterface{
    saver(path: string): void {
        throw new Error("Method not implemented.");
    }

}

export {
    JsonSaver,
}
