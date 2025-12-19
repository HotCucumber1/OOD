import type {CommandInterface} from "./History";

abstract class AbstractTask implements CommandInterface {
    private isExecuted = false;

    public execute(): void {
        if (!this.isExecuted) {
            this.doExecute();
            this.isExecuted = true;
        }
    }

    public unexecute(): void {
        if (this.isExecuted) {
            this.doUnexecute();
            this.isExecuted = false;
        }
    }

    public replaceEdit(command: CommandInterface): boolean {
        return false;
    }

    public destroy(): void {
    }

    protected abstract doExecute(): void;

    protected abstract doUnexecute(): void;
}

export {
    AbstractTask,
}
