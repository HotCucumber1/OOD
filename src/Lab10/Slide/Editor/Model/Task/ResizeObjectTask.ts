import {AbstractTask} from "../../../Common/History/AbstractTask";
import type {CommandInterface} from "../../../Common/History/History";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";

class ResizeObjectTask extends AbstractTask {
    private oldWidth: number = 0;
    private oldHeight: number = 0;

    public constructor(
        private object: SlideComponentInterface,
        private newWidth: number,
        private newHeight: number,
    ) {
        super();
    }

    public replaceEdit(command: CommandInterface): boolean {
        if (!(command instanceof this.constructor)) {
            return false;
        }

        const other = command as ResizeObjectTask;
        if (this.object !== other.object) {
            return false;
        }

        this.oldWidth = other.oldWidth;
        this.oldHeight = other.oldHeight;
        return true;
    }

    protected doExecute(): void {
        this.oldWidth = this.object.getFrame().getWidth();
        this.oldHeight = this.object.getFrame().getHeight();

        this.object.resize(
            this.newWidth,
            this.newHeight,
        );
    }

    protected doUnexecute(): void {
        this.object.resize(
            this.oldWidth,
            this.oldHeight,
        );
    }
}

export {
    ResizeObjectTask,
};
