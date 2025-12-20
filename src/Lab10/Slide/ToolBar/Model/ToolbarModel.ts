type ToolType = 'select' | 'rectangle' | 'triangle' | 'ellipse' | 'image';

interface Tool {
    id: ToolType;
    name: string;
    icon: string;
}

class ToolbarModel {
    private tools: Tool[] = [
        {id: 'rectangle', name: 'Квадрат', icon: '■'},
        {id: 'ellipse', name: 'Эллипс', icon: '●'},
        {id: 'triangle', name: 'Треугольник', icon: '▲'},
    ];

    private selectedTool: ToolType = 'rectangle';

    public getTools(): Tool[] {
        return this.tools;
    }

    public getSelectedTool(): ToolType {
        return this.selectedTool;
    }

    public selectTool(toolId: ToolType): void {
        this.selectedTool = toolId;
    }
}

export {
    type ToolType,
    type Tool,
    ToolbarModel,
};
