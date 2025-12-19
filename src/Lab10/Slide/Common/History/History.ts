interface CommandInterface {
    execute(): void;

    unexecute(): void;

    replaceEdit(command: CommandInterface): boolean;

    destroy(): void;
}

class History {
    private MAX_DEPTH = 20;
    private commands: CommandInterface[] = [];
    private nextCommandIndex = 0;

    public canUndo(): boolean {
        return this.nextCommandIndex !== 0;
    }

    public undo(): void {
        if (this.canUndo()) {
            this.commands[--this.nextCommandIndex]?.unexecute();
        }
    }

    public canRedo(): boolean {
        return this.nextCommandIndex !== this.commands.length;
    }

    public redo(): void {
        if (this.canRedo()) {
            this.commands[this.nextCommandIndex]?.execute();
            this.nextCommandIndex++;
        }
    }

    public addAndExecuteCommand(command: CommandInterface): void {
        command.execute();

        if (this.nextCommandIndex < this.commands.length) {
            const removed = this.commands.splice(this.nextCommandIndex);
            this.cleanUp(removed);
        }

        const wasMerged = this.tryMerge(command);
        if (!wasMerged) {
            this.addNewCommand(command);
            this.nextCommandIndex++;
        }
    }

    private tryMerge(command: CommandInterface): boolean {
        if (this.nextCommandIndex === 0) {
            return false;
        }
        const lastCommand = this.commands[this.nextCommandIndex - 1];

        // @ts-ignore
        if (command.replaceEdit(lastCommand)) {
            this.commands[this.nextCommandIndex - 1] = command;
            return true;
        }
        return false;
    }

    private addNewCommand(command: CommandInterface): void {
        if (this.commands.length >= this.MAX_DEPTH) {
            const removed = this.commands.shift();
            removed?.destroy();
            this.nextCommandIndex--;
        }
        this.commands.push(command);
    }

    private cleanUp(commands: CommandInterface[]): void {
        commands.forEach(command => {
            command.destroy();
        });
    }
}

export {
    History,
    type CommandInterface,
};
