import {DocumentModel} from "../Model/Entity/DocumentModel";
import {SlideView} from "../View/SlideView";
import type {SlideComponentInterface} from "../Model/Interface/SlideComponentInterface";
import {type Color, Frame, type Point} from "../../Common/Common";
import type {ObserverInterface} from "../../Common/Observer/ObserverInterface";


type ShapeType = 'rectangle' | 'ellipse' | 'triangle';

class SlidePresenter implements ObserverInterface {
    private view: SlideView;
    private selected: SlideComponentInterface[] = [];
    private canDrag = false;
    private needGroup = false;
    private dragLastPosition: Point = {x: 0, y: 0};

    public constructor(
        private model: DocumentModel,
        viewId: string,
    ) {
        this.view = new SlideView(viewId);
        this.setupViewListeners();
    }

    public update(objects: SlideComponentInterface[]): void {
        this.render();
    }

    public addShape(type: ShapeType, color: Color): void {
        const position = this.view.getDefaultFrame();

        switch (type) {
            case "rectangle":
                this.model.addRectangle(
                    {x: position.getTopLeft().x, y: position.getTopLeft().y},
                    {x: position.getBottomRight().x, y: position.getBottomRight().y},
                    color,
                );
                break;
            case "ellipse":
                this.model.addEllipse({
                        x: position.getTopLeft().x + position.getWidth() / 2,
                        y: position.getTopLeft().y + position.getHeight() / 2,
                    },
                    position.getWidth() / 2,
                    position.getHeight() / 2,
                    color,
                );
                break;
            case "triangle":
                const [p1, p2, p3] = this.getTrianglePoints(position);
                this.model.addTriangle(
                    p1, p2, p3, color,
                );
                break;
        }
    }

    public render(): void {
        this.view.renderObjects(this.getObjects());
        this.view.renderSelection(this.selected);
    }

    public addImage(src: string): void {
        const position = this.view.getDefaultFrame();

        this.model.addImage(
            position.getTopLeft(),
            position.getWidth(),
            position.getHeight(),
            src,
        );
    }

    private getObjects(): SlideComponentInterface[] {
        return Array.from(this.model.getObjects().values());
    }

    public destroy(): void {
    }

    private getTrianglePoints(frame: Frame): [Point, Point, Point] {
        return [
            {
                x: frame.getTopLeft().x + frame.getWidth() / 2,
                y: frame.getTopLeft().y,
            },
            {
                x: frame.getBottomRight().x,
                y: frame.getBottomRight().y,
            },
            {
                x: frame.getTopLeft().x,
                y: frame.getBottomRight().y,
            },
        ];
    }

    private setupViewListeners(): void {
        this.view.onObjectClick((x: number, y: number) => {
            this.handleSelection(x, y);
        });

        this.view.onMouseDown((x: number, y: number) => {
            this.canDrag = true;
            this.dragLastPosition = {x: x, y: y};
        });

        this.view.onMouseUp((x: number, y: number) => {
            this.canDrag = false;
            this.dragLastPosition = {x: 0, y: 0};
        });

        this.view.onMouseMove((x: number, y: number) => {
            this.handleDrag(x, y);
        });

        this.view.onDeleteKeyDown(() => {
            this.handleDelete();
        });

        this.view.onUndoKeyDown(() => {
            this.model.undo();
        });

        this.view.onRedoKeyDown(() => {
            this.model.redo();
        });

        this.view.onCollectKeyDown(() => {
            this.needGroup = true;
        })

        this.view.onCollectKeyUp(() => {
            this.needGroup = false;
        })
    }

    private handleSelection(x: number, y: number): void {
        const objects = this.getObjects();

        if (!this.needGroup) {
            this.selected = [];
        }

        for (const object of objects.reverse()) {
            if (this.isObjectClicked(object, x, y) && !this.selected.includes(object)) {
                this.selected.push(object);
                break;
            }
        }

        this.render();
    }
    // TODO вынести useCase в отдельные классы

    private handleDrag(x: number, y: number): void {
        if (!this.canDrag) {
            return;
        }

        const offsetX = x - this.dragLastPosition.x;
        const offsetY = y - this.dragLastPosition.y;

        this.dragLastPosition = {
            x: x,
            y: y,
        };

        const objectsMap = this.model.getObjects();
        for (const [key, val] of objectsMap.entries()) {
            if (this.selected.includes(val)) {
                this.model.changeObjectPosition(
                    key,
                    val.getFrame().getTopLeft().x + offsetX,
                    val.getFrame().getTopLeft().y + offsetY,
                );
            }
        }
    }

    private handleDelete(): void {
        let toDelete = [];

        const objectsMap = this.model.getObjects();
        for (const [key, val] of objectsMap.entries()) {
            if (this.selected.includes(val)) {
                toDelete.push(key);
            }
        }

        this.selected = [];
        this.model.deleteObjects(toDelete);
    }

    private isObjectClicked(object: SlideComponentInterface, x: number, y: number): boolean {
        const frame = object.getFrame();
        // TODO логика нажатия

        return frame.getTopLeft().x <= x && x <= frame.getBottomRight().x &&
            frame.getTopLeft().y <= y && y <= frame.getBottomRight().y;
    }
}

export {
    SlidePresenter,
    type ShapeType,
};
