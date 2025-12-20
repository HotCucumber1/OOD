import type {ObservableInterface} from "../../../Common/Observer/ObservableInterface";
import type {ObserverInterface} from "../../../Common/Observer/ObserverInterface";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import type {SaverInterface} from "../Service/SaverInterface";
import type {Color, Point} from "../../../Common/Common";
import {AbstractShape} from "./AbstractShape";
import {History} from "../../../Common/History/History";
import {AddRectangleTask} from "../Task/AddRectangleTask";
import {AddEllipseTask} from "../Task/AddEllipseTask";
import {AddTriangleTask} from "../Task/AddTriangleTask";
import {AddImageTask} from "../Task/AddImageTask";
import {ImageSave} from "../Service/ImageSave";
import {ResizeObjectTask} from "../Task/ResizeObjectTask";
import {DeleteObjectTask} from "../Task/DeleteObjectTask";
import {MoveObjectTask} from "../Task/MoveObjectTask";
import {AddGroupTask} from "../Task/AddGroupTask";

class DocumentModel implements ObservableInterface {
    private observers: ObserverInterface[] = [];
    private items = new Map<string, SlideComponentInterface>();
    private history = new History();

    public constructor(
        private saver: SaverInterface,
    ) {
    }

    public addRectangle(topLeft: Point, bottomRight: Point, color: Color): void {
        this.history.addAndExecuteCommand(
            new AddRectangleTask(
                this.items,
                topLeft,
                bottomRight,
                color,
            ),
        );
        this.notifyObservers();
    }

    public addEllipse(center: Point, rx: number, ry: number, color: Color): void {
        this.history.addAndExecuteCommand(
            new AddEllipseTask(
                this.items,
                center,
                rx,
                ry,
                color,
            ),
        );
        this.notifyObservers();
    }

    public addTriangle(p1: Point, p2: Point, p3: Point, color: Color): void {
        this.history.addAndExecuteCommand(
            new AddTriangleTask(
                this.items,
                p1,
                p2,
                p3,
                color,
            ),
        );
        this.notifyObservers();
    }

    public addImage(pos: Point, width: number, height: number, src: string): void {
        this.history.addAndExecuteCommand(
            new AddImageTask(
                this.items,
                pos,
                width,
                height,
                src,
                new ImageSave(),
            ),
        );
        this.notifyObservers();
    }

    public groupObjects(objectIds: string[]): void {
        this.history.addAndExecuteCommand(
            new AddGroupTask(
                this.items,
                objectIds,
            ),
        );
    }

    public deleteObjects(objectsIds: string[]): void {
        this.history.addAndExecuteCommand(
            new DeleteObjectTask(
                this.items,
                objectsIds,
            ),
        );
        this.notifyObservers();
    }

    public resizeObject(objectId: string, newWidth: number, newHeight: number): void {
        const object = this.getObject(objectId);
        this.history.addAndExecuteCommand(
            new ResizeObjectTask(
                object,
                newWidth,
                newHeight,
            ),
        );
        this.notifyObservers();
    }

    public changeObjectPosition(objectId: string, newX: number, newY: number): void {
        const object = this.getObject(objectId);
        this.history.addAndExecuteCommand(
            new MoveObjectTask(
                object,
                {x: newX, y: newY},
            ),
        );
        this.notifyObservers();
    }

    public setObjectColor(objectId: string, newColor: Color): void {
        const object = this.getObject(objectId);

        if (object instanceof AbstractShape) {
            object.setColor(newColor);
        }
        this.notifyObservers();
    }

    public getObjects(): Map<string, SlideComponentInterface> {
        return this.items;
    }

    public undo(): void {
        this.history.undo();
        this.notifyObservers();
    }

    public redo(): void {
        this.history.redo();
        this.notifyObservers();
    }

    public notifyObservers(): void {
        this.observers.forEach(observer => {
            observer.update(Array.from(this.items.values()));
        });
    }

    public registerObserver(observer: ObserverInterface): void {
        this.observers.push(observer);
    }

    public removeObserver(observer: ObserverInterface): void {
        this.observers = this.observers.filter(item => item !== observer);
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
