import type {ObservableInterface} from "../../../Common/ObservableInterface";
import type {ObserverInterface} from "../../../Common/ObserverInterface";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import type {SaverInterface} from "../Service/SaverInterface";
import {History} from "./History";
import type {Color, Point} from "../../../Common/Common";
import {AbstractShape} from "./AbstractShape";
import {Rectangle} from "./Rectangle";
import {Ellipse} from "./Ellipse";
import {Triangle} from "./Triangle";
import {Image} from "./Image";

class DocumentModel implements ObservableInterface {
    private observers: ObservableInterface[] = [];
    private items = new Map<string, SlideComponentInterface>();
    private history = new History();

    public constructor(
        private saver: SaverInterface,
    ) {
    }

    public addRectangle(topLeft: Point, bottomRight: Point, color: Color): string {
        const rect = new Rectangle(
            topLeft.x,
            topLeft.y,
            bottomRight.x,
            bottomRight.y,
            color,
        );
        return this.storeObject(rect);
    }

    public addEllipse(center: Point, rx: number, ry: number, color: Color): string {
        const ellipse = new Ellipse(center, rx, ry, color);
        return this.storeObject(ellipse);
    }

    public addTriangle(p1: Point, p2: Point, p3: Point, color: Color): string {
        const triangle = new Triangle({p1: p1, p2: p2, p3: p3}, color);
        return this.storeObject(triangle);
    }

    public addImage(pos: Point, width: number, height: number, src: string): string {
        const img = new Image(
            pos.x,
            pos.y,
            width,
            height,
            src,
        );
        return this.storeObject(img);
    }

    public deleteObjects(objectsIds: string[]): void {
        objectsIds.forEach(id => {
            this.items.delete(id);
        })
    }

    public resizeObject(objectId: string, newWidth: number, newHeight: number): void {
        const object = this.getObject(objectId);
        object.resize(newWidth, newHeight);
    }

    public changeObjectPosition(objectId: string, newX: number, newY: number): void {
        const object = this.getObject(objectId);
        object.setPosition(newX, newY);
    }

    public setObjectColor(objectId: string, newColor: Color): void {
        const object = this.getObject(objectId);

        if (object instanceof AbstractShape) {
            object.setColor(newColor);
        }
    }

    public getObjects(): Map<string, SlideComponentInterface> {
        return this.items;
    }

    public notifyObservers(): void {
    }

    public registerObserver(observer: ObserverInterface): void {
    }

    public removeObserver(observer: ObserverInterface): void {
    }

    private storeObject(object: SlideComponentInterface): string {
        const uuid = crypto.randomUUID();
        this.items.set(uuid, object);

        return uuid;
    }

    private getObject(objectId: string): SlideComponentInterface {
        const object = this.items.get(objectId);
        if (!object) {
            throw new Error(`Object with id ${objectId} not found`);
        }
        return object;
    }
}

export {
    DocumentModel,
};
