import {ToolbarModel, type ToolType} from "../Model/ToolbarModel";

interface ToolbarPresenterInterface {
    getViewProps(): ToolbarViewProps;

    handleShapeClick(shapeId: string): void;

    handleAddShape(): void;

    handleImageUpload(): Promise<string | null>;
}

type ToolbarViewProps = {
    tools: {
        id: string;
        name: string;
        icon: string;
    }[];
    selectedTool: string;
    onToolSelect: (toolId: string) => void;
    onImageUpload: () => void;
    onAddShape: () => void;
}

class ToolbarPresenter implements ToolbarPresenterInterface {
    private model: ToolbarModel;
    private readonly onShapeSelect?: (shapeId: ToolType) => void;
    private readonly onAddShape?: () => void;
    private readonly onImageLoaded?: (imagePath: string) => void;

    public constructor(
        onShapeSelect: (shapeId: ToolType) => void,
        onAddShape: () => void,
        onImageLoaded: (imagePath: string) => void
    ) {
        this.model = new ToolbarModel();
        this.onShapeSelect = onShapeSelect;
        this.onAddShape = onAddShape;
        this.onImageLoaded = onImageLoaded;
    }

    public getViewProps(): ToolbarViewProps {
        return {
            tools: this.model.getTools().filter(tool => tool.id !== 'select'),
            selectedTool: this.model.getSelectedTool(),
            onToolSelect: (shapeId) => this.handleShapeClick(shapeId),
            onImageUpload: () => this.handleImageUpload(),
            onAddShape: () => this.handleAddShape()
        };
    }

    public handleShapeClick(shapeId: string): void {
        const validShapeIds: ToolType[] = ['rectangle', 'triangle', 'ellipse'];

        if (validShapeIds.includes(shapeId as ToolType)) {
            this.model.selectTool(shapeId as ToolType);
            this.onShapeSelect?.(shapeId as ToolType);
        }
    }

    public handleAddShape(): void {
        this.onAddShape?.();
    }

    async handleImageUpload(): Promise<string | null> {
        try {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.style.display = 'none';

            const file = await new Promise<File | null>((resolve) => {
                input.onchange = () => {
                    resolve(input.files?.[0] || null);
                    document.body.removeChild(input);
                };
                input.oncancel = () => {
                    resolve(null);
                    document.body.removeChild(input);
                };
                document.body.appendChild(input);
                input.click();
            });

            if (!file) {
                return null;
            }

            const imageUrl = await this.readFileAsDataURL(file);
            this.onImageLoaded?.(imageUrl);
            return imageUrl;

        } catch (error) {
            console.error('Error uploading image:', error);
            return null;
        }
    }

    private readFileAsDataURL(file: File): Promise<string> {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (event) => resolve(event.target?.result as string);
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }
}

export {
    type ToolbarPresenterInterface,
    type ToolbarViewProps,
    ToolbarPresenter,
};
