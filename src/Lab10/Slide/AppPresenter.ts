import {SlidePresenter} from "./Editor/Presenter/SlidePresenter";
import {
    ToolbarPresenter,
    type ToolbarPresenterInterface,
    type ToolbarViewProps
} from "./ToolBar/Presenter/ToolBarPresenter";
import type {DocumentModel} from "./Editor/Model/Entity/DocumentModel";
import type {ToolType} from "./ToolBar/Model/ToolbarModel";
import type {Color} from "./Common/Common";

interface AppViewProps {
    toolbarProps: ToolbarViewProps;
}

class AppPresenter {
    private defaultColor: Color = {hex: '#FF603D'};
    private slidePresenter: SlidePresenter;
    private toolbarPresenter: ToolbarPresenterInterface;
    private currentShapeType: ToolType = 'rectangle';

    public constructor(
        model: DocumentModel,
        canvas: string,
        private updateView: (props: AppViewProps) => void,
    ) {
        this.slidePresenter = new SlidePresenter(model, canvas);
        model.registerObserver(this.slidePresenter);

        this.toolbarPresenter = new ToolbarPresenter(
            (shapeId) => this.onShapeSelected(shapeId),
            () => this.onAddShapeClicked(),
            (imagePath) => this.onImageLoaded(imagePath)
        );

        this.updateViewState();

        this.addRectangle();
        this.slidePresenter.addShape('ellipse', {hex: "#AABBCC"});
    }

    public destroy(): void {
        this.slidePresenter.destroy();
    }

    private updateViewState(): void {
        const toolbarProps = this.toolbarPresenter.getViewProps();

        this.updateView({toolbarProps});
    }

    private onAddShapeClicked(): void {
        console.log(`Adding shape: ${this.currentShapeType}`);

        switch (this.currentShapeType) {
            case 'rectangle':
                this.addRectangle();
                break;
            case 'triangle':
                this.addTriangle();
                break;
            case 'ellipse':
                this.addEllipse();
                break;
            default:
                console.warn('Unknown shape type');
        }
    }

    private onShapeSelected(shapeId: ToolType): void {
        this.currentShapeType = shapeId;
        console.log(`Shape selected: ${shapeId}`);
    }

    public addRectangle(): void {
        this.slidePresenter.addShape('rectangle', this.defaultColor);
    }

    public addTriangle(): void {
        this.slidePresenter.addShape('triangle', this.defaultColor);
    }

    public addEllipse(): void {
        this.slidePresenter.addShape('ellipse', this.defaultColor);
    }

    private onImageLoaded(imagePath: string): void {
        console.log('Image loaded:', imagePath);
        this.slidePresenter.addImage(imagePath);
    }
}

export {
    AppPresenter,
    type AppViewProps,
};
