import type {ViewInterface} from "../View/ViewInterface";
import {DocumentModel} from "../Model/Entity/DocumentModel";
import {SlideView} from "../View/SlideView";
import type {SlideComponentInterface} from "../Model/Interface/SlideComponentInterface";
import {type Color, Frame, type Point} from "../../Common/Common";


type ShapeType = 'rectangle' | 'ellipse' | 'triangle';

class SlidePresenter {
    private view: ViewInterface;
    private selected: SlideComponentInterface[] = [];

    public constructor(
        private model: DocumentModel,
        viewId: string,
    ) {
        this.view = new SlideView(viewId);
        this.setupViewListeners();
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
                this.model.addEllipse(
                    {
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
        this.render();
    }

    public render(): void {
        this.view.renderObjects(
            Array.from(this.model.getObjects().values()),
        );
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
        console.log('Setup');
        this.view.onObjectClick((objectId) => {
            this.handleObjectClick(objectId);
        });
    }

    private handleObjectClick(objectId: string): void {
    }
}

export {
    SlidePresenter,
    type ShapeType,
};
