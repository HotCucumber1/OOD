import {AbstractTask} from "../../../Common/History/AbstractTask";
import type {Point} from "../../../Common/Common";
import type {SlideComponentInterface} from "../Interface/SlideComponentInterface";
import type {CommandInterface} from "../../../Common/History/History";

class MoveObjectTask extends AbstractTask {
    private oldPosition: Point = {x: 0, y: 0};

    public constructor(
        private object: SlideComponentInterface,
        private newPosition: Point,
    ) {
        super();
    }

    public replaceEdit(command: CommandInterface): boolean {
        if (!(command instanceof this.constructor)) {
            return false;
        }

        const other = command as MoveObjectTask;
        if (this.object !== other.object) {
            return false;
        }

        this.oldPosition = other.oldPosition;
        return true;
    }

    protected doExecute(): void {
        this.oldPosition = this.object.getFrame().getTopLeft();

        this.object.setPosition(
            this.newPosition.x,
            this.newPosition.y,
        );
    }

    protected doUnexecute(): void {
        this.object.setPosition(
            this.oldPosition.x,
            this.oldPosition.y
        );
    }
}

export {
    MoveObjectTask,
}
